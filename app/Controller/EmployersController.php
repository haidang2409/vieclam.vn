<?php
App::uses('AppController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('CakeEmail', 'Network/Email');
class EmployersController extends AppController
{
    //Import
    public $components = array('Mailtemplate', 'Library');
    //User
    //////////////////////////////
    function employer_list()
    {

    }
    function employer_detail()
    {

    }

    //Employer
    //////////////////////////////
    function register()
    {
        $this->layout = 'ajax';
        //Post
        if($this->request->is('post'))
        {
            $this->Employer->set('logo', 'employer_default.jpg');
            $this->Employer->set('company_link', $this->Library->make_link($this->request->data['Employer']['company_name']));
            if($this->Employer->save($this->request->data, true, array('email', 'password', 'repassword', 'company_name', 'company_link', 'logo')))
            {
                $email = $this->request->data['Employer']['email'];
                $employer_id = $this->Employer->id;
                $code_active = md5(md5($email . $employer_id));
                $this->Employer->query("UPDATE employers SET is_active_email = 1, code_active_email = '" . $code_active . "' WHERE id = " . $employer_id);
                //Send mail
                $Email = new CakeEmail('smtp');
                $Email->to($email);
                $Email->subject('Kích hoạt');
                $Email->emailFormat('html');
                $Email->message();
                $body = $this->Mailtemplate->email_register_employer($email, $code_active);
                try
                {
                    $Email->send($body);
                }
                catch (Exception $exception)
                {

                }
                //
                $this->Session->setFlash('Đăng ký tài khoản thành công, vui lòng kiểm tra lại email để kích hoạt tài khoản');
                $this->redirect($this->_base_url_employer . '/dang-nhap');
            }
        }

    }
    function active_email()
    {
        $this->layout = 'ajax';
        $email = isset($this->params['url']['email'])? $this->params['url']['email']: '';
        $code_active = isset($this->params['url']['code_active'])? $this->params['url']['code_active']: '';
        $this->Employer->recursive = -1;
        $employers = $this->Employer->find('first', array(
            'conditions' => array(
                'email' => $email,
                'is_active_email' => 1
            )
        ));
        if($employers)
        {
            $this->redirect($this->_base_url_employer . '/dang-nhap');
        }
        else
        {
            $employers = $this->Employer->find('first', array(
                'fields' => array('id'),
                'conditions' => array(
                    'email' => $email,
                    'code_active_email' => $code_active,
                )
            ));
            if($employers)
            {
                $this->Employer->query("UPDATE employers SET is_active_email = 1, code_active_email = ''");
                $this->Session->setFlash('Tài khoản đã được kích hoạt');
            }
            else
            {
                $this->Session->setFlash('Kích hoạt tài khoản không thành công');
            }
        }

    }
    function login()
    {
        if($this->Session->check('S_Employer'))
        {
            $this->redirect($this->_base_url_employer);
        }
        $this->layout = 'ajax';
        if($this->request->is('post'))
        {
            $email = $this->request->data['email'];
            $password = $this->request->data['password'];
            $this->Employer->recursive = -1;
            $employers = $this->Employer->find('first', array(
                'fields' => array(
                    'id', 'email', 'logo', 'is_active_email'
                ),
                'conditions' => array(
                    'email' => $email,
                    'password' => AuthComponent::password($password)
                )
            ));
            if($employers)
            {
                if($employers['Employer']['is_active_email'] == 0)
                {
                    $this->Session->setFlash('Tài khoản chưa được kích hoạt, vui lòng kiểm tra lại email. Nếu không tìm thấy trong inbox vui lòng kiểm tra lại trong hộp thư spam');
                }
                else
                {
                    $this->Session->write('S_Employer.id', $employers['Employer']['id']);
                    $this->Session->write('S_Employer.email', $employers['Employer']['email']);
                    $this->Session->write('S_Employer.logo', $employers['Employer']['logo']);
                    $last_login = date('Y-m-d h:i:s');
                    $data_update = array(
                        'id' => $employers['Employer']['id'],
                        'last_login' => $last_login
                    );
                    $this->Employer->save($data_update);
                    $this->redirect($this->_base_url_employer);
                }
            }
            else
            {
                $this->Session->setFlash('Email hoặc mật khẩu không đúng');
            }
        }
    }
    function logout()
    {
        $this->is_login_employer();
        $this->Session->delete('S_Employer');
        $this->redirect($this->_base_url_employer);
    }
    public function forget_password()
    {
        //
        $this->layout = 'ajax';
        if($this->Session->check('S_Employer'))
        {
            $this->redirect('/nha-tuyen-dung');
        }
        //
        if($this->request->is('post'))
        {
            $email = isset($this->request->data['email'])? $this->request->data['email']: '';
            $this->Employer->recursive = -1;
            $employers = $this->Employer->findByEmail($email);
            if(!$employers)
            {
                $this->Session->setFlash('Không tìm thấy email');
            }
            else
            {
                $code_change = md5(md5($email . mt_rand()));
                $this->Employer->recursive = -1;
                if($this->Employer->updateAll(array('code_change_password' => "'$code_change'"), array('Employer.id' => $employers['Employer']['id'], 'Employer.email' => $email)))
                {
                    //Send mail
                    $Email = new CakeEmail('smtp');
                    $Email->to($email);
                    $Email->subject('Yêu cầu đặt lại mật khẩu');
                    $Email->emailFormat('html');
                    $Email->message();
                    $body = $this->Mailtemplate->email_forget_password($email, $code_change);
                    try
                    {
                        $Email->send($body);
                    }
                    catch (Exception $exception)
                    {

                    }
                    $this->redirect('/nha-tuyen-dung/change_password_status?status=sent_email&code=' . md5(mt_rand()));
                }
            }
        }
    }
    public function reset_password()
    {
        $this->layout = 'ajax';
        $code = isset($this->params['url']['code'])? $this->params['url']['code']: '';
        $email = isset($this->params['url']['email'])? $this->params['url']['email']: '';
        //
        $this->Employer->recursive = -1;
        $employers = $this->Employer->find('first', array(
            'fields' => array(
                'Employer.id',
                'Employer.email'
            ),
            'conditions' => array(
                'Employer.email' => $email,
                'Employer.code_change_password' => $code
            )
        ));
        if(!$employers)
        {
            $this->redirect('/nha-tuyen-dung/change_password_status?status=fail&code=' . md5(mt_rand()));
        }
        else
        {
            //
            $this->set(array('title' => 'Đặt lại mật khẩu'));
        }
        if($this->request->is('post') || $this->request->is('put'))
        {
            $password = $this->request->data['password_new'];
            $re_password = $this->request->data['re_password_new'];
            if(trim($password) == '')
            {
                $this->Session->setFlash('Vui lòng nhập mật khẩu');
            }
            else
            {
                if(trim($re_password) == '')
                {
                    $this->Session->setFlash('Vui lòng nhập lại mật khẩu');
                }
                else
                {
                    if(strlen($password) < 8)
                    {
                        $this->Session->setFlash('Mật khẩu từ 8 ký tự');
                    }
                    else
                    {
                        if($password != $re_password)
                        {
                            $this->Session->setFlash('Mật khẩu không khớp nhau');
                        }
                        else
                        {
                            $pass_new = AuthComponent::password($re_password);
                            $data_update_member = array(
                                'Employer.id' => $employers['Employer']['id'],
                                'Employer.email' => $email,
                                'Employer.code_change_password' => $code
                            );
                            if($this->Employer->updateAll(array('password' => "'$pass_new'", 'code_change_password' => "''"), array($data_update_member)))
                            {
                                $this->redirect('/nha-tuyen-dung/change_password_status?status=success&code=' . md5(mt_rand()));
                            }
                        }
                    }
                }
            }
        }
    }
    function change_password_status()
    {
        $this->layout = 'ajax';
        $status = isset($this->params['url']['status'])? $this->params['url']['status']: '';
        if($status == '')
        {
            $this->redirect('/nha-tuyen-dung');
        }
        $this->set(array('status' => $status));
    }
    function profile()
    {
        $this->is_login_employer();
        $this->layout = 'employer_default';
        //
        $employer_id = $this->Session->read('S_Employer.id');
        $this->Employer->recursive = -1;
        $employers = $this->Employer->find('first', array(
            'joins' => array(
                array(
                    'table' => 'provinces',
                    'alias' => 'Province',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Employer.province_id = Province.id'
                ),
                array(
                    'table' => 'scales',
                    'alias' => 'Scale',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Employer.scale_id = Scale.id'
                ),
            ),
            'fields' => array(
                'Employer.id', 'Employer.company_name', 'Employer.email', 'Employer.address', 'Employer.phone',
                'Employer.fullname', 'Employer.description', 'Employer.logo', 'Employer.website', 'Employer.video',
                'Province.id',
                'Scale.id',
            ),
            'conditions' => array(
                'Employer.is_active_email' => 1,
                'Employer.id' => $employer_id
            )
        ));
        if(!$employers)
        {
            $this->redirect($this->_base_url_employer . '/');
        }
        //Get All Job of employer
        ClassRegistry::init('EmployerJob')->recursive = -1;
        $employers_jobs = ClassRegistry::init('EmployerJob')->find('all', array(
            'conditions' => array(
                'employer_id' => $employer_id
            )
        ));
        //Get list Province
        $provinces = null;
        $this->Employer->Province->recursive = -1;
        $province = $this->Employer->Province->find('all', array(
            'order' => array('Province.provincename' => 'ASC')
        ));
        if($province)
        {
            foreach ($province as $item)
            {
                $provinces[$item['Province']['id']] = $item['Province']['provincename'];
            }
        }
        //Get list Scale
        $scales = null;
        $this->Employer->Scale->recursive = -1;
        $scale = $this->Employer->Scale->find('all', array(
            'order' => array('Scale.sort' => 'ASC')
        ));
        if($scale)
        {
            foreach ($scale as $item)
            {
                $scales[$item['Scale']['id']] = $item['Scale']['scale_name'];
            }
        }
        //Get list Jobs
        $jobs = null;
        ClassRegistry::init('Job')->recursive = -1;
        $job = ClassRegistry::init('Job')->find('all', array(
            'conditions' => array()
        ));
        if($job)
        {
            foreach ($job as $item)
            {
                $jobs[$item['Job']['id']] = $item['Job']['jobname'];
            }
        }
        //Set
        $this->set(
            array(
                'employers_jobs' => $employers_jobs,
                'jobs' => $jobs,
                'scales' => $scales,
                'provinces' => $provinces,
                'employers' => $employers,
                'title' => 'Cập nhật thông tin nhà tuyển dụng'
            )
        );
        //////////////////////////////
        //Post
        if($this->request->is('post'))
        {
            //Kiem tra nganh nghe
            $data_employers_jobs = $this->request->data['Employer']['employers_jobs'];
            if(count($data_employers_jobs) == 0 || $data_employers_jobs == '')
            {
                $this->Session->setFlash('Vui lòng chọn ngành nghề', 'flashWarning');
            }
            else
            {
                $employer_id = $this->Session->read('S_Employer.id');
                $this->Employer->id = $employer_id;
                if($this->Employer->save($this->request->data))
                {
                    //Xóa ngành nghề cũ
                    $this->Employer->EmployerJob->deleteAll(array('employer_id' => $employer_id));
                    for ($i = 0; $i < count($data_employers_jobs); $i++)
                    {
                        if($data_employers_jobs[$i] != '')
                        {
                            $this->Employer->EmployerJob->set('employer_id', $employer_id);
                            $this->Employer->EmployerJob->set('job_id', $data_employers_jobs[$i]);
                            $this->Employer->EmployerJob->saveAll();
                        }
                    }
                }
            }


        }

    }
    function change_logo()
    {
        $this->is_login_employer();
        $this->layout = 'employer_default';
        $employer_id = $this->Session->read('S_Employer.id');
        $this->Employer->recursive = -1;
        $employers = $this->Employer->find('first', array(
            'fields' => array(
                'Employer.logo',
                'Employer.website',
                'Employer.video',
            ),
            'conditions' => array(
                'Employer.id' => $employer_id
            )
        ));
        $this->set(array(
            'title' => 'Thay đổi logo công ty',
            'employers' => $employers
        ));

        //Pots
        if($this->request->is('post'))
        {
            $file = time() . '.jpg';
            $file_path = $this->path_company_logo . '/' . $file;
            $imgData = $this->request->data['Employer']['logo'];
            if($imgData != '')
            {
                try
                {
                    $this->Library->base64_to_jpeg($imgData, $file_path);
                    $this->Employer->set('id', $employer_id);
                    $this->Employer->set('website', $this->request->data['Employer']['website']);
                    $this->Employer->set('website', $this->request->data['Employer']['website']);
                    $this->Employer->set('video', $this->request->data['Employer']['video']);
                    $this->Employer->set('logo', $file);
                    $this->Employer->save();
                    if($employers['Employer']['logo'] != 'employer_default.jpg' && $employers['Employer']['logo'] != ''
                    && file_exists(WWW_ROOT . '/uploads/company/' . $employers['Employer']['logo']))
                    {
                        unlink($this->path_company_logo . '/' . $employers['Employer']['logo']);
                    }
                    $this->redirect('/nha-tuyen-dung/thay-doi-logo');
                }
                catch (Exception $exception)
                {

                }


            }

        }


    }
    function index()
    {
        $this->layout = 'employer_default';
        $this->is_login_employer();
        $employer_id = $this->Session->read('S_Employer.id');
        //Count Recruitment
        $this->Employer->Recruitment->recursive = -1;
        $this->Employer->Recruitment->find();
        //Count recruitment
        $count_recruitment = $this->Employer->Recruitment->find('count', array(
            'conditions' => array(
                'employer_id' => $employer_id
            )
        ));
        debug($count_recruitment);

        //Count resume saved


        $this->set(array(
            'title' => 'Trang quản trị nhà tuyển dụng'
        ));
    }
    function job()
    {
        $this->is_login_employer();
        $this->layout = 'employer_default';
        $status = isset($this->params['status'])? $this->params['status']: '';
        $date = getdate();
        $cur_date = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'];
        $cur_time = $date['hours'] . '-' . $date['minutes'] . '-' . $date['seconds'];
        $employer_id = $this->Session->read('S_Employer.id');
        //Dieu kien
        $conditions = array(
            'Recruitment.employer_id' => $employer_id,
            'Recruitment.status' => 1,
            'Recruitment.is_paid' => 1,
            'Order.deleted' => 0,
            'Order.status' => 1,
            'Order.expiry >= ' => $cur_date,
        );
        if($status == 'draft')
        {
            $conditions = array(
                'Recruitment.employer_id' => $employer_id,
                'Recruitment.status' => 1,
                'Recruitment.is_paid' => 0,
            );
        }
        if($status == 'expried')
        {
            $conditions = array(
                'Recruitment.employer_id' => $employer_id,
                'Recruitment.status' => 1,
                'Recruitment.is_paid' => 1,
                'Order.deleted' => 0,
                'Order.status' => 1,
                'Order.expiry < ' => $cur_date
            );
        }
        if($status == 'hidden')
        {
            $conditions = array(
                'Recruitment.employer_id' => $employer_id,
                'Recruitment.status' => 0,
                'Recruitment.is_paid' => 1,
                'Order.deleted' => 0,
                'Order.status' => 1,
                'Order.expiry >= ' => $cur_date,
            );
        }

        $jobs = null;
        $this->Employer->Recruitment->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'employers',
                    'alias' => 'Employer',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.employer_id = Employer.id'
                ),
                array(
                    'table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.id = Order.recruitment_id'
                ),
            ),
            'fields' => array(
                'Recruitment.id',
                'Recruitment.title',
                'Recruitment.view',
                'Order.expiry',
            ),
            'order' => array('Recruitment.id' => 'DESC'),
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'limit' => 10
        );
        try
        {
            $jobs = $this->paginate('Recruitment');
        }
        catch (Exception $exception)
        {

        }
        //Set
        $this->set(array(
            'jobs' => $jobs,
            'title' => 'Danh sách việc làm'
        ));
    }
    function get_count_apply()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Employer'))
        {
            $data = null;
            $employer_id = $this->Session->read('S_Employer');
            $this->Employer->Recruitment->recursive = -1;
            $recruitments = $this->Employer->Recruitment->find('all', array(
                'fields' => array('id'),
                'conditions' => array('employer_id' => $employer_id)
            ));
            if($recruitments)
            {
                $i = 0;
                foreach ($recruitments as $item)
                {
                    $this->Employer->Recruitment->recursive = -1;
                    $count_applied = $this->Employer->Recruitment->MemberRecruitment->find('count', array(
                        'conditions' => array(
                            'MemberRecruitment.is_applied' => 1,
                            'MemberRecruitment.recruitment_id' => $item['Recruitment']['id']
                        ),
                    ));
                    $this->Employer->Recruitment->recursive = -1;
                    $count_applied_viewed = $this->Employer->Recruitment->MemberRecruitment->find('count', array(
                        'conditions' => array(
                            'MemberRecruitment.is_applied' => 1,
                            'MemberRecruitment.is_viewed' => 1,
                            'MemberRecruitment.recruitment_id' => $item['Recruitment']['id']
                        ),
                    ));
                    $data[$i] = array(
                        'recruitment' => $item['Recruitment']['id'],
                        'sum' => $count_applied,
                        'viewed' => $count_applied_viewed
                    );
                    $i = $i + 1;
                }
            }
            echo json_encode($data);
        }
        else
        {
            echo '';
        }
    }
    function candidate()
    {
        $this->is_login_employer();
        $url = $this->params['url'];
        $employer_id = $this->Session->read('S_Employer.id');
        $this->layout = 'employer_default';
        $s_recruitment_id = isset($url['recruitmentId'])? $url['recruitmentId']: '';
        $s_recruitmentStatus = isset($url['recruitmentStatus'])? $url['recruitmentStatus']: '';
        $s_is_viewed = isset($url['isViewed'])? $url['isViewed']: '';
        $condition_recruitment_id = '';
        if($s_recruitment_id != '')
        {
            $condition_recruitment_id = 'Recruitment.id = ' . $s_recruitment_id;
        }
        $condition_recruitmentStatus = '';
        if($s_recruitmentStatus != '')
        {
            $condition_recruitmentStatus = 'MemberRecruitment.recruitment_status_id = ' . $s_recruitmentStatus;
        }
        $conditions_is_viewed = '';
        if($s_is_viewed != '')
        {
            $conditions_is_viewed = 'MemberRecruitment.is_viewed = ' . $s_is_viewed;
        }
        //Danh sách ứng viên
        $candidates = null;
        $this->Employer->Recruitment->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'members_recruitments',
                    'alias' => 'MemberRecruitment',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'MemberRecruitment.recruitment_id = Recruitment.id'
                ),
                array(
                    'table' => 'recruitments_status',
                    'alias' => 'RecruitmentStatus',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'MemberRecruitment.recruitment_status_id = RecruitmentStatus.id'
                ),
                array(
                    'table' => 'members',
                    'alias' => 'Member',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'MemberRecruitment.member_id = Member.id'
                ),
                array(
                    'table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.id = Order.recruitment_id'
                )
            ),
            'fields' => array(
                'Recruitment.title',
                'Recruitment.id',
                'MemberRecruitment.id',
                'MemberRecruitment.member_id',
                'MemberRecruitment.date_applied',
                'MemberRecruitment.is_viewed',
                'MemberRecruitment.recruitment_status_id',
                'Member.id',
                'Member.fullname',
                'Member.title',
                'Member.experience',
                'RecruitmentStatus.status_name',
                'RecruitmentStatus.color',
            ),
            'conditions' => array(
                //Điều kiện tin, còn hoặc hết hạn, không xóa, không ẩn, đã trả tiền
                'Recruitment.employer_id' => $employer_id,
                'Recruitment.status' => 1,
                'Recruitment.is_paid' => 1,
                'Recruitment.deleted' => 0,
                $condition_recruitment_id,
                $condition_recruitmentStatus,
                $conditions_is_viewed,
                'MemberRecruitment.is_applied' => 1

            ),
            'order' => array('MemberRecruitment.date_applied' => 'DESC'),
            'limit' => 10,
            'paramType' => 'querystring'
        );
        try
        {
            $candidates = $this->paginate('Recruitment');
        }
        catch (Exception $exception)
        {

        }
        //Danh sách tin tuyển dụng lên option
        $recruitments_option = null;
        $this->Employer->Recruitment->recursive = -1;
        $recruitments = $this->Employer->Recruitment->find('all', array(
            'joins' => array(
                array(
                    'table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.id = Order.recruitment_id'
                )
            ),
            'fields' => array(
                'Recruitment.title',
                'Recruitment.id',
            ),
            'conditions' => array(
                //Điều kiện tin, còn hoặc hết hạn, không xóa, không ẩn, đã trả tiền
                'Recruitment.employer_id' => $employer_id,
                'Recruitment.status' => 1,
                'Recruitment.is_paid' => 1,
                'Recruitment.deleted' => 0,
            )
        ));
        if($recruitments)
        {
            foreach ($recruitments as $item)
            {
                $recruitments_option[$item['Recruitment']['id']] = $item['Recruitment']['title'];
            }
        }
        //Danh sách trạng thái hồ sơ, đã gửi mail, đã pv, đã đạt
        $status = null;
        ClassRegistry::init('RecruitmentStatus')->recursive = -1;
        $status = ClassRegistry::init('RecruitmentStatus')->find('all');
        //Danh sách mảng các hồ sơ đã lưu(trong bảng members_employers)
        //Lấy member_id
        $this->Employer->MemberEmployer->recursive = -1;
        $arr_resume_saved = null;
        $resume_saved = $this->Employer->MemberEmployer->find('all', array(
            'fields' => array('MemberEmployer.member_id'),
            'conditions' => array(
                'employer_id' => $employer_id,
                'is_saved' => 1
            )
        ));
        if($resume_saved)
        {
            $i = 0;
            foreach ($resume_saved as $item)
            {
                $arr_resume_saved[$i] = $item['MemberEmployer']['member_id'];
                $i = $i + 1;
            }
        }
        //Set
        $this->set(array(
            'candidates' => $candidates,
            'recruitments_option' => $recruitments_option,
            'title' => 'Hồ sơ dự tuyển',
            'status' => $status,
            'arr_resume_saved' => $arr_resume_saved,
            //Trả lại điều kiện tìm kiếm
            'recruitmentId' => $s_recruitment_id
        ));
    }
    function resume_saved()
    {
        $url = $this->params['url'];
        $s_folder_id = isset($url['folder'])? $url['folder']: '';
        $condition_folder = '';
        if($s_folder_id != '')
        {
            $condition_folder = 'Folder.id = ' . $s_folder_id;
        }
        $this->layout = 'employer_default';
        $this->is_login_employer();
        $employer_id = $this->Session->read('S_Employer.id');
        $resume_saved = null;
        $this->Employer->MemberEmployer->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'members',
                    'alias' => 'Member',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'MemberEmployer.member_id = Member.id'
                ),
                array(
                    'table' => 'folders',
                    'alias' => 'Folder',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'MemberEmployer.folder_id = Folder.id'
                )
            ),
            'fields' => array(
                'Member.fullname',
                'Member.title',
                'Member.id',
                'Member.experience',
                'MemberEmployer.id',
                'MemberEmployer.date_saved',
                'Folder.folder_name',
                'Folder.id',
            ),
            'conditions' => array(
                'MemberEmployer.is_saved' => 1,
                'MemberEmployer.employer_id' => $employer_id,
                //
                $condition_folder
            ),
            'order' => array('MemberEmployer.date_saved' => 'DESC'),
            'limit' => 10,
            'paramType' => 'querystring'
        );
        try
        {
            $resume_saved = $this->paginate('MemberEmployer');
        }
        catch (Exception $exception)
        {

        }
        $this->Employer->Folder->recursive = -1;
        $folders = $this->Employer->Folder->find('all', array(
            'conditions' => array(
                'employer_id' => $employer_id,
            ),
            'order' => array('Folder.folder_name')
        ));
        $this->set(array(
            'folders' => $folders,
            'resume_saved' => $resume_saved,
            'title' => 'Hồ sơ đã lưu'
        ));

    }

    //Admin
    //////////////////////////////
    function admin_index()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $employers = null;
        $this->Employer->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'provinces',
                    'alias' => 'Province',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Employer.province_id = Province.id'
                ),
                array(
                    'table' => 'scales',
                    'alias' => 'Scale',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Employer.scale_id = Scale.id'
                )
            ),
            'fields' => array(
                'Employer.id',
                'Employer.company_name',
                'Employer.email',
                'Employer.phone',
                'Employer.status',
                'Province.provincename',
                'Province.id',
                'Scale.scale_name',
                'Scale.id'
            ),
            'conditions' => array(

            ),
            'limit' => 10,
            'paramType' => 'querystring',
            'order' => array(
                'Employer.id' => 'DESC'
            )
        );
        try
        {
            $employers = $this->paginate('Employer');
        }
        catch (Exception $exception)
        {

        }

        //Set
        $this->set(array(
            'title' => 'Nhà tuyển dụng',
            'employers' => $employers
        ));

    }
    function admin_view_detail($id = '')
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $this->Employer->recursive = -1;
        $employers = $this->Employer->find('first', array(
            'joins' => array(
                array(
                    'table' => 'provinces',
                    'alias' => 'Province',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Employer.province_id = Province.id'
                ),
                array(
                    'table' => 'scales',
                    'alias' => 'Scale',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Employer.scale_id = Scale.id'
                )
            ),
            'fields' => array(
                '*'
            ),
            'conditions' => array(
                'Employer.id' => $id
            )
        ));
        if($employers)
        {
            $employers_jobs = null;
            ClassRegistry::init('EmployerJob')->recursive = -1;
            $employers_jobs = ClassRegistry::init('EmployerJob')->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'jobs',
                        'alias' => 'Job',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'EmployerJob.job_id = Job.id'
                    )
                ),
                'fields' => array(
                    'Job.jobname'
                ),
                'conditions' => array(
                    'EmployerJob.employer_id' => $id
                )
            ));
            $employers_benefits = null;
            $this->Employer->EmployerBenefit->recursive = -1;
            $employers_benefits = $this->Employer->EmployerBenefit->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'benefits',
                        'alias' => 'Benefit',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'EmployerBenefit.benefit_id = Benefit.id'
                    )
                ),
                'fields' => array(
                    'Benefit.icon',
                    'EmployerBenefit.note'
                ),
                'conditions' => array(
                    'EmployerBenefit.employer_id' => $id
                )
            ));
            $this->set(array(
                'title' => $employers['Employer']['company_name'],
                'employers' => $employers,
                'employers_jobs' => $employers_jobs,
                'employers_benefits' => $employers_benefits
            ));
        }
        else
        {
            $this->redirect('/admin/employers');
        }
    }


}