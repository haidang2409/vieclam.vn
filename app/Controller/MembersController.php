<?php
App::uses('AppController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('ProvincesController', 'Controller');
App::uses('LevelsController', 'Controller');
App::uses('LanguagesController', 'Controller');
App::uses('LanguagesLevelsController', 'Controller');
App::uses('DegreesController', 'Controller');
App::uses('JobsController', 'Controller');
App::uses('SkillsController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class MembersController extends AppController
{
    //Import
    public $components = array('Mailtemplate', 'Library');

    //User
    ///////////////////////////////
    function check_email()
    {
        $this->autoRender = false;
        if($this->request->is('post'))
        {
            $email = $this->request->data['email'];
            $this->Member->recursive = -1;
            $members = $this->Member->findByEmail($email);
            if($members)
            {
                echo json_encode(array('status' => 'exist'));
            }
            else
            {
                echo json_encode(array('status' => 'success'));
            }
        }
    }
    function register()
    {
        $this->set(array(
            'title' => 'Đăng ký thành viên',
        ));
        //Post
        if($this->Session->check('S_Member'))
        {
            $this->redirect('/');
            exit();
        }
        if($this->request->is('post'))
        {
            $this->Member->create();
            $this->Member->set('status', 1);
            $this->Member->set('image', 'default_user.jpg');
            if ($this->Member->save($this->request->data))
            {
                $fullname = $this->request->data['Member']['fullname'];
                $email = $this->request->data['Member']['email'];
                $member_id = $this->Member->id;
                $code_active = md5(md5($email.$member_id));
                $this->Member->query("UPDATE members SET is_active_email = 0, code_active_email = '" . $code_active . "' WHERE id = " . $member_id);
                //Send mail
                $Email = new CakeEmail('smtp');
                $Email->to($email);
                $Email->subject('Kích hoạt tài khoản');
                $Email->emailFormat('html');
                $Email->message();
                $body = $this->Mailtemplate->email_register($fullname, $email, $member_id, $code_active);
                //
                //Send email
                try
                {
//                    $Email->send($body);
                }
                catch (Exception $exception)
                {

                }
                //
                $this->Session->setFlash('Đăng ký tài khoản thành công', 'flashSuccess');
                $this->redirect('/dang-nhap');
            }
            else
            {
                return $this->Member->validationErrors;
            }

        }
    }
    public function login()
    {
        if($this->Session->check('S_Member'))
        {
            $this->redirect('/');
            exit();
        }
        $this->set(array(
            'title' => 'Đăng nhập'
        ));
        if($this->request->is('post'))
        {
            $email = $this->request->data['email'];
            $password = $this->request->data['password'];
            $passwordnew = AuthComponent::password($password);
            $this->Member->recursive = -1;
            $members = $this->Member->find('first', array(
                'conditions' => array(
                    'Member.email' => $email,
                    'Member.password' => $passwordnew,
                )
            ));
            if($members)
            {
                if($members['Member']['status'] == 0)
                {
                    $this->Session->setFlash('Tài khoản của bạn đã bị khóa, vui lòng liên hệ với quản trị website', 'flashWarning');
                    $this->redirect('/dang-nhap');
                }
                else
                {
                    $this->Session->write('S_Member.fullname', $members['Member']['fullname']);
                    $this->Session->write('S_Member.email', $members['Member']['email']);
                    $this->Session->write('S_Member.id', $members['Member']['id']);
                    $this->Session->write('S_Member.avatar', $members['Member']['avatar']);
                    $date = getdate();
                    $lastlogin = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'] . ' ' . $date['hours'] . ':' . $date['minutes'] . ':' . $date['seconds'];
                    $data_update = array(
                        'id' => $members['Member']['id'],
                        'lastlogin' => $lastlogin
                    );
                    $this->Member->save($data_update);
                    if(isset($this->request->data['redirect']))
                    {
                        $this->redirect($this->request->data['redirect']);
                    }
                    else
                    {
                        $this->redirect('/tim-viec-lam');
                    }
                }
            }
            else
            {
                $this->Session->setFlash('Tên đăng nhập hoặc mật khẩu không đúng','flashError');
                $this->redirect('/dang-nhap');
            }
        }
    }
    public function active_email()
    {
        $url = $this->params['url'];
        $email = isset($url['email'])? $url['email']: '';
        $code_active = isset($url['code_active'])? $url['code_active']: '';
        $this->Member->recursive = -1;
        $members = $this->Member->find('first', array(
            'conditions' => array(
                'Member.email' => $email
            )
        ));
        if($members)
        {
            if($members['Member']['is_active_email'] == 1)
            {
                $this->Session->setFlash('Email của bạn đã xác thực rồi', 'flashSuccess');
            }
            else
            {
                if($members['Member']['code_active_email'] == $code_active)
                {
                    $data_update = array(
                        'is_active_email' => 1,
                        'code_active_email' => null,
                    );
                    $this->Member->updateAll(
                        $data_update,
                        array('Member.email' => $email)
                    );
                    $this->Session->setFlash('Email của bạn đã được xác thực', 'flashSuccess');
                }
                else
                {
                    $this->Session->setFlash('Mã kích hoạt không đúng', 'flashWarning');
                }
            }

        }
        else
        {
            $this->Session->setFlash('Thông tin thành viên không đúng', 'flashWarning');
        }
    }
    public function logout()
    {
        $this->Session->delete('S_Member');
        $this->redirect($this->referer());
    }
    function forget_password()
    {

    }
    function reset_password()
    {

    }
    function update_profile()
    {
        $this->is_login_member();
        $member_id = $this->Session->read('S_Member.id');
        $this->Member->recursive = -1;
        $members = $this->Member->find('first', array(
            'joins' => array(
               array(
                   'table' => 'provinces',
                   'alias' => 'Province',
                   'type' => 'LEFT',
                   'foreignKey' => false,
                   'conditions' => 'Member.province_id = Province.id'
               )
            ),
            'fields' => array('Member.*'),
            'conditions' => array('Member.id' => $member_id)
        ));
        if($members)
        {
            //Province
            $Province = new ProvincesController();
            $provinces = $Province->_get_province_option();
            //set
            $this->set(array(
                'provinces' => $provinces,
                'members' => $members,
                'title' => 'Cập nhật tài khoản'
            ));
        }
        else
        {
            $this->redirect('/');
        }
        //Post
        if($this->request->is('post'))
        {
            $this->Member->set('id', $member_id);
            if($this->Member->save($this->request->data, true, array('fullname', 'gender', 'address', 'province_id', 'phonenumber')))
            {
                $this->Session->setFlash('Đã cập nhật', 'flashSuccess');
                $this->redirect('/cap-nhat-tai-khoan');
            }
        }

    }
    function update_resume()
    {
        $this->is_login_member();
        $member_id = $this->Session->read('S_Member.id');
        $this->Member->recursive = -1;
        $members = $this->Member->find('first', array(
            'joins' => array(
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.level_id = Level.id'
                ),
            ),
            'fields' => array('Member.*', 'Level.*'),
            'conditions' => array(
                'Member.id' => $member_id
            )
        ));
        $per_complete = 0;
        if($members)
        {
            //%
            $hint_update = '';
            if($members['Member']['title'] && $members['Member']['experience'] && $members['Member']['level_id'])
            {
                $per_complete = $per_complete + 10;
            }
            else
            {
                $hint_update .= '<li>Thêm chức danh, kinh nghiệm, cấp bậc</li>';
            }
            if($members['Member']['introduce'])
            {
                $per_complete = $per_complete + 10;
            }
            else
            {
                $hint_update .= '<li>Thêm mục tiêu nghề nghiệp</li>';
            }
            if($members['Member']['f_profile'])
            {
                $per_complete = $per_complete + 10;
            }
            else
            {
                $hint_update .= '<li>Bổ sung CV của bạn</li>';
            }
            //
            //Lấy các dữ liệu liên quan đến hồ sơ
            //Degrees Bằng cấp, ts, ths, dh cd, tc..
            $members_degrees = null;
            $this->Member->MemberDegree->recursive = -1;
            $members_degrees = $this->Member->MemberDegree->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'degrees',
                        'alias' => 'Degree',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberDegree.degree_id = Degree.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Degree.sort' => 'DESC'), //Để lấy bằng cao nhất vị trí [0] trong mảng
                'conditions' => array('MemberDegree.member_id' => $member_id)
            ));
            //%
            if($members_degrees)
            {
                $per_complete = $per_complete + 10;
            }
            else
            {
                $hint_update .= '<li>Bổ sung bằng cấp</li>';
            }
            //Skill Kỹ năng
            $members_skills = null;
            $this->Member->MemberSkill->recursive = -1;
            $members_skills = $this->Member->MemberSkill->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'skills',
                        'alias' => 'Skill',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberSkill.skill_id = Skill.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('MemberSkill.member_id' => $member_id)
            ));
            if($members_skills)
            {
                $per_complete = $per_complete + 10;
            }
            else
            {
                $hint_update .= '<li>Thêm kỹ năng của bạn</li>';
            }
            //Refer tham khảo
            $refers = null;
            $this->Member->Refer->recursive = -1;
            $refers = $this->Member->Refer->find('all', array(
                'conditions' => array('member_id' => $member_id)
            ));
            if($refers)
            {
                $per_complete = $per_complete + 10;
            }
            else
            {
                $hint_update .= '<li>Thêm thông tin tham khảo</li>';
            }
            //MemberLanguage
            $members_languages = null;
            $this->Member->MemberLanguage->recursive = -1;
            $members_languages = $this->Member->MemberLanguage->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'languages',
                        'alias' => 'Language',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_id = Language.id'
                    ),
                    array(
                        'table' => 'languages_levels',
                        'alias' => 'LanguageLevel',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_level_id = LanguageLevel.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Language.language_name' => 'ASC'),
                'conditions' => array('MemberLanguage.member_id' => $member_id)
            ));
            if($members_languages)
            {
                $per_complete = $per_complete + 10;
            }
            else
            {
                $hint_update .= '<li>Bổ sung ngoại ngữ</li>';
            }
            //Lịch sử làm việc
            $words = null;
            $this->Member->Work->recursive = -1;
            $words = $this->Member->Work->find('all', array(
                'conditions' => array('Work.member_id' => $member_id),
                'order' => array('Work.is_now' => 'DESC', 'Work.to' => 'DESC', 'id' => 'DESC')
            ));
            if($words)
            {
                $per_complete = $per_complete + 10;
            }
            else
            {
                $hint_update .= '<li>Thêm kinh nghiệm làm việc</li>';
            }
            //Việc làm mong muốn
            $desires = null;
            $this->Member->Desire->recursive = -1;
            $desires = $this->Member->Desire->find('first', array(
                'joins' => array(
                    array(
                        'table' => 'levels',
                        'alias' => 'Level',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'Desire.level_id = Level.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('Desire.member_id' => $member_id)
            ));
            $desires_jobs = null;
            $desires_province = null;
            $desire_benefits = null;
            if($desires)
            {
                $per_complete = $per_complete + 20;
                $desire_id = $desires['Desire']['id'];
                //Các ngành nghề mong muốn
                $this->Member->Desire->DesireJob->recursive = -1;
                $desires_jobs = $this->Member->Desire->DesireJob->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'jobs',
                            'alias' => 'Job',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireJob.job_id = Job.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireJob.desire_id' => $desire_id)
                ));
                //Nơi làm việc mong muốn
                $this->Member->Desire->DesireProvince->recursive = -1;
                $desires_province = $this->Member->Desire->DesireProvince->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'provinces',
                            'alias' => 'Province',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireProvince.province_id = Province.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireProvince.desire_id' => $desire_id)
                ));
                //Phú lợi mong muốn
                $this->Member->Desire->DesireBenefit->recursive = -1;
                $desire_benefits = $this->Member->Desire->DesireBenefit->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'benefits',
                            'alias' => 'Benefit',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireBenefit.benefit_id = Benefit.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireBenefit.desire_id' => $desire_id),
                ));
            }
            else
            {
                $hint_update .= '<li>Cập nhật công việc mong muốn của bạn</li>';
            }
            //Lấy các dữ liệu load lên options để chọn khi update
            $Level = new LevelsController();
            $levels = $Level->_get_levels_option();
            //Degree Bằng Cấp
            $Degree = new DegreesController();
            $degrees = $Degree->_get_degrees_option();
            //Skill Kỹ năng
            $Skill = new SkillsController();
            $skills = $Skill->_get_skills_option();
            //Language Ngôn ngữ
            $Language = new LanguagesController();
            $languages = $Language->_get_languages_option();
            //Language levels Trình độ ngô ngữ
            $LanguageLevel = new LanguagesLevelsController();
            $languages_levels = $LanguageLevel->_get_languages_levels_option();
            //Jobs ngành nghề mong muốn (chọn)
            $Job = new JobsController();
            $jobs = $Job->_get_jobs_option();
            //Nơi làm việc mong muốn
            $provinces = null;
            $Province = new ProvincesController();
            $provinces = $Province->_get_province_option();
            //Benefit
            $benefits = null;
            ClassRegistry::init('Benefit')->recursive = -1;
            $benefits = ClassRegistry::init('Benefit')->find('all');
            //Update per_complete - Mức độ hoàn thành hồ sơ
            if($members['Member']['per_complete'] != $per_complete)
            {
                $this->Member->query('UPDATE members SET per_complete = ' . $per_complete . ' WHERE id = ' . $member_id);
                //Sau khi update xong trả về mức độ hoàn thành mới
                $this->Member->recursive = -1;
                $data_per_complete = $this->Member->find('first', array('fields' => array('Member.per_complete'), 'conditions' => array('Member.id' => $member_id)));
                //Set lại $members['Member']['per_complete']
                $members['Member']['per_complete'] = $data_per_complete['Member']['per_complete'];
            }
            //Set

            $this->set(array(
                'members' => $members,
                'members_degrees' => $members_degrees,
                'members_skills' => $members_skills,
                'refers' => $refers,
                'members_languages' => $members_languages,
                'works' => $words,
                'desires' => $desires,
                'desires_jobs' => $desires_jobs,
                'desires_provinces' => $desires_province,
                'desires_benefits' => $desire_benefits,
                'title' => 'Cập nhật hồ sơ',
                'hint_update' => htmlentities('<ul class="ul-hint-update">' . $hint_update . '</ul>', ENT_QUOTES, 'UTF-8'),
                //Dữ liệu option
                'levels' => $levels,
                'degrees' => $degrees,
                'skills' => $skills,
                'languages' => $languages,
                'languages_levels' => $languages_levels,
                'jobs' => $jobs,
                'provinces' => $provinces,
                'benefits' => $benefits,
            ));
            ////////////////////////

        }
        else
        {
            $this->redirect('/');
        }
    }
    function update_resume_ajax()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Member'))
        {
            if($this->request->is('post'))
            {
                $data = $this->request->data;
                $action = $data['action'];
                $member_id = $this->Session->read('S_Member.id');
                if($action == 'update_general')
                {
                    $fullname = $data['fullname'];
                    $title = $data['title'];
                    $experience = $data['experience'];
                    $level = $data['level'];
                    $this->Member->set('id',  $member_id);
                    $data = array(
                        'fullname' => $fullname,
                        'title' => $title,
                        'experience' => $experience,
                        'level_id' => $level
                    );
                    if($this->Member->save($data, true, array('fullname', 'title', 'experience', 'level_id')))
                    {
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'update_summary')
                {
                    $summary = $data['summary'];
                    $this->Member->set('id', $member_id);
                    if($this->Member->save(array('introduce' => $summary, true, array('introduce'))))
                    {
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'add_language')
                {
                    $language = $data['language'];
                    $language_level = $data['language_level'];
                    $this->Member->MemberLanguage->recursive = -1;
                    $count = $this->Member->MemberLanguage->find('count', array(
                        'conditions' => array(
                            'member_id' => $member_id,
                            'language_id' => $language
                        )
                    ));
                    if($count > 0)
                    {
                        echo json_encode(array('status' => 'exist'));
                    }
                    else
                    {
                        $data = array(
                            'member_id' => $member_id,
                            'language_id' => $language,
                            'language_level_id' => $language_level
                        );
                        if($this->Member->MemberLanguage->save($data))
                        {
                            echo json_encode(array('status' => 'success'));
                        }
                        else
                        {
                            echo json_encode(array('status' => 'fail'));
                        }
                    }
                }
                if($action == 'edit_language')
                {
                    $ml_id = $data['ml_id'];
                    $language = $data['language'];
                    $language_level = $data['language_level'];
                    $this->Member->MemberLanguage->recursive = -1;
                    $data_members_languages = $this->Member->MemberLanguage->find('first', array(
                        'conditions' => array(
                            'member_id' => $member_id,
                            'language_id' => $language,
                            'id !=' => $ml_id
                        )
                    ));
                    //Đã tồn tại ngôn ngữ
                    if(count($data_members_languages) > 0)
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                    //Không tồn tại update ngay tại ID đang gửi
                    else
                    {
                        $data = array(
                            'language_id' => $language,
                            'language_level_id' => $language_level
                        );
                        if($this->Member->MemberLanguage->updateAll($data, array('MemberLanguage.id' => $ml_id, 'member_id' => $member_id)))
                        {
                            echo json_encode(array('status' => 'success'));
                        }
                        else
                        {
                            echo json_encode(array('status' => 'fail'));
                        }
                    }
                }
                if($action == 'delete_language')
                {
                    $id = $data['id'];
                    if($this->Member->MemberLanguage->deleteAll(array('MemberLanguage.id' => $id, 'MemberLanguage.member_id' => $member_id)))
                    {
//                        $this->Session->setFlash('Đã xóa ngôn ngữ', 'flashSuccess');
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'add_work')
                {
                    $title = $data['title'];
                    $company_name = $data['company_name'];
                    $from = $data['from'];
                    $to = $data['to'];
                    $summary = $data['summary'];
                    $is_now = $data['is_now'];
                    if($is_now == 1)
                    {
                        $to = '';
                    }
                    $data = array(
                        'member_id' => $member_id,
                        'title' => $title,
                        'company_name' => $company_name,
                        'from' => $from,
                        'to' => $to,
                        'summary' => $summary,
                        'is_now' => $is_now
                    );
                    if($this->Member->Work->save($data))
                    {
//                        $this->Session->setFlash('Đã cập nhật', 'flashSuccess');
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'delete_work')
                {
                    $id = $data['id'];
                    if($this->Member->Work->deleteAll(array('Work.id' => $id, 'member_id' => $member_id)))
                    {
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'update_work')
                {
                    $title = $data['title'];
                    $company_name = $data['company_name'];
                    $from = $data['from'];
                    $to = $data['to'];
                    $summary = $data['summary'];
                    $is_now = $data['is_now'];
                    $id = $data['id'];
                    if($is_now == 1)
                    {
                        $to = '';
                    }
                    $data = array(
                        'Work.title' => "'$title'",
                        'Work.company_name' => "'$company_name'",
                        'Work.from' => "'$from'",
                        'Work.to' => "'$to'",
                        'Work.summary' => "'$summary'",
                        'Work.is_now' => "'$is_now'"
                    );
                    if($this->Member->Work->updateAll($data, array('Work.id' => $id, 'Work.member_id' => $member_id)))
                    {
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'add_degree')
                {
                    $specialized = $data['specialized'];
                    $school = $data['school'];
                    $from = $data['from'];
                    $to = $data['to'];
                    $degree = $data['degree'];
                    $data = array(
                        'member_id' => $member_id,
                        'degree_id' => $degree,
                        'school' => $school,
                        'specialized' => $specialized,
                        'from' => $from,
                        'to' => $to,
                    );
                    if($this->Member->MemberDegree->save($data))
                    {
//                        $this->Session->setFlash('Đã cập nhật', 'flashSuccess');
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'delete_degree')
                {
                    $id = $data['id'];
                    if($this->Member->MemberDegree->deleteAll(array('MemberDegree.id' => $id, 'MemberDegree.member_id' => $member_id)))
                    {
//                        $this->Session->setFlash('Đã xóa học vấn', 'flashSuccess');
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'update_degree')
                {
                    $specialized = $data['specialized'];
                    $school = $data['school'];
                    $from = $data['from'];
                    $to = $data['to'];
                    $degree = $data['degree'];
                    $id = $data['id'];
                    $data = array(
                        'degree_id' => "'$degree'",
                        'school' => "'$school'",
                        'specialized' => "'$specialized'",
                        'from' => "'$from'",
                        'to' => "'$to'",
                    );
                    if($this->Member->MemberDegree->updateAll($data, array('MemberDegree.id' => $id, 'MemberDegree.member_id' => $member_id)))
                    {
//                        $this->Session->setFlash('Đã cập nhật', 'flashSuccess');
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'add_refer')
                {
                    $fullname = $data['fullname'];
                    $title = $data['title'];
                    $company = $data['company'];
                    $email = $data['email'];
                    $phone = $data['phone'];
                    $data = array(
                        'member_id' => $member_id,
                        'fullname' => $fullname,
                        'title' => $title,
                        'company' => $company,
                        'email' => $email,
                        'phone' => $phone,
                    );
                    if($this->Member->Refer->save($data))
                    {
//                        $this->Session->setFlash('Đã cập nhật', 'flashSuccess');
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'delete_refer')
                {
                    $id = $data['id'];
                    if($this->Member->Refer->deleteAll(array('Refer.id' => $id, 'Refer.member_id' => $member_id)))
                    {
//                        $this->Session->setFlash('Đã xóa', 'flashSuccess');
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'update_refer')
                {
                    $fullname = $data['fullname'];
                    $title = $data['title'];
                    $company = $data['company'];
                    $email = $data['email'];
                    $phone = $data['phone'];
                    $id = $data['id'];
                    $data = array(
                        'fullname' => "'$fullname'",
                        'title' => "'$title'",
                        'company' => "'$company'",
                        'email' => "'$email'",
                        'phone' => "'$phone'",
                    );
                    if($this->Member->Refer->updateAll($data, array('Refer.id' => $id, 'Refer.member_id' => $member_id)))
                    {
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
                if($action == 'update_desire')
                {
                    $desire_job = $data['desire_job'];
                    $desire_province = $data['desire_province'];
                    $desire_level = $data['desire_level'];
                    $desire_salary = $data['desire_salary'];
                    $desire_benefit = isset($data['desire_benefit'])? $data['desire_benefit']: null;
                    $count_desire_job = count($desire_job);
                    $count_desire_province = count($desire_province);
                    $count_desire_benefit = count($desire_benefit);
                    //Kiểm tra xem update hay insert
                    $this->Member->Desire->recursive = -1;
                    $desire = $this->Member->Desire->findByMemberId($member_id);
                    if($desire)
                    {
                        //Đã có => Update
                        $data = array(
                            'level_id' => "'$desire_level'",
                            'salary' => "'$desire_salary'"
                        );
                        if($this->Member->Desire->updateAll($data, array('Desire.id' => $desire['Desire']['id'], 'member_id' => $member_id)))
                        {
                            //Xóa các dữ liệu cũ

                            //Lưu công việc mong muốn
                            $desire_id = $desire['Desire']['id'];
                            $this->Member->Desire->DesireJob->deleteAll(array('desire_id' => $desire_id));
                            $this->Member->Desire->DesireProvince->deleteAll(array('desire_id' => $desire_id));
                            $this->Member->Desire->DesireBenefit->deleteAll(array('desire_id' => $desire_id));
                            for($i = 0; $i < $count_desire_job; $i++)
                            {
                                $data_dersire_job = array(
                                    'desire_id' => $desire_id,
                                    'job_id' => $desire_job[$i]
                                );
                                $this->Member->Desire->DesireJob->saveAll($data_dersire_job);
                            }
                            //Lưu nơi làm việc mong muốn
                            for($j = 0; $j < $count_desire_province; $j++)
                            {
                                $data_dersire_province = array(
                                    'desire_id' => $desire_id,
                                    'province_id' => $desire_province[$j]
                                );
                                $this->Member->Desire->DesireProvince->saveAll($data_dersire_province);
                            }
                            //Lưu phúc lợi mong muốn
                            for ($k = 0; $k < $count_desire_benefit; $k++)
                            {
                                $data_desire_benefit = array(
                                    'desire_id' => $desire_id,
                                    'benefit_id' => $desire_benefit[$k]
                                );
                                $this->Member->Desire->DesireBenefit->saveAll($data_desire_benefit);
                            }
                            //
//                            $this->Session->setFlash('Đã cập nhật công việc mong muốn', 'flashSuccess');
                            echo json_encode(array('status' => 'success'));
                        }
                        else
                        {
                            echo json_encode(array('status' => 'fail'));
                        }

                    }
                    else
                    {
                        //Chưa có => Insert
                        $data = array(
                            'member_id' => $member_id,
                            'level_id' => $desire_level,
                            'salary' => $desire_salary
                        );
                        if($this->Member->Desire->save($data))
                        {
                            //Lưu thành công
                            //Lưu công việc mong muốn
                            $desire_id = $this->Member->Desire->id;
                            for($i = 0; $i < $count_desire_job; $i++)
                            {
                                $data_dersire_job = array(
                                    'desire_id' => $desire_id,
                                    'job_id' => $desire_job[$i]
                                );
                                $this->Member->Desire->DesireJob->saveAll($data_dersire_job);
                            }
                            //Lưu nơi làm việc mong muốn
                            for($j = 0; $j < $count_desire_province; $j++)
                            {
                                $data_dersire_province = array(
                                    'desire_id' => $desire_id,
                                    'province_id' => $desire_province[$j]
                                );
                                $this->Member->Desire->DesireProvince->saveAll($data_dersire_province);
                            }
                            //Lưu phúc lợi mong muốn
                            for ($k = 0; $k < $count_desire_benefit; $k++)
                            {
                                $data_desire_benefit = array(
                                    'desire_id' => $desire_id,
                                    'benefit_id' => $desire_benefit[$k]
                                );
                                $this->Member->Desire->DesireBenefit->saveAll($data_desire_benefit);
                            }
                            //
//                            $this->Session->setFlash('Đã cập nhật công việc mong muốn', 'flashSuccess');
                            echo json_encode(array('status' => 'success'));
                        }
                        else
                        {
//                            $this->Session->setFlash('Lỗi. Vui lòng thử lại sau', 'flashError');
                            echo json_encode(array('status' => 'fail'));
                        }
                    }
                }
                if($action == 'allow_search')
                {
                    $allow = $data['allow_search'];
                    if($this->Member->updateAll(array('allow_search' => $allow), array('Member.id' => $member_id)))
                    {
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
            }
        }
        else
        {
            echo json_encode(array('status' => 'fail'));
        }
    }
    function update_avatar()
    {
        $this->is_login_member();
        $member_id = $this->Session->read('S_Member.id');
        $avatar = $this->request->data['Member']['avatar'];
        if($this->request->is('post'))
        {
            if($avatar['name'] == '')
            {
                $this->Session->setFlash('Vui lòng chọn hình ảnh', 'flashWarning');
                $this->redirect('/cap-nhat-ho-so');
            }
            if($avatar['type'] != 'image/png' && $avatar['type'] != 'image/jpg' && $avatar['type'] != 'image/jpeg')
            {
                $this->Session->setFlash('Vui lòng chọn hình ảnh', 'flashWarning');
                $this->redirect('/cap-nhat-ho-so');
            }
            if($avatar['size'] > 1000000)
            {
                $this->Session->setFlash('Vui lòng chọn hình ảnh nhỏ hơn 1Mb', 'flashWarning');
                $this->redirect('/cap-nhat-ho-so');
            }
            $this->Member->recursive = -1;
            $members = $this->Member->findById($member_id);
            if($members)
            {
                $date = new DateTime();
                $timestamp = $date->getTimestamp();
                $ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);
                $file = 'index' . $members['Member']['id'] . $timestamp . '.' . $ext;
                $image_old = $members['Member']['avatar'];
                if(move_uploaded_file($avatar['tmp_name'], $this->path_member_avatar . '/' . $file))
                {
                    if($image_old != 'default_user.jpg')
                    {
                        unlink($this->path_member_avatar . '/' . $image_old);
                    }
                    $this->Member->set('id', $member_id);
                    $data_update = array(
                        'avatar' => $file
                    );
                    if($this->Member->save($data_update))
                    {
                        $this->Session->write('Member.avatar', $file);
                        $this->Session->setFlash('Hình ảnh đã được thay đổi', 'flashSuccess');
                        $this->redirect('/cap-nhat-ho-so');
                    }
                }
            }
        }

    }
    function recruitments_saved()
    {
        $this->is_login_member();
        $member_id = $this->Session->read('S_Member.id');
        $recruitments_saved = null;
        $now = $this->get_curr_date();
        $this->Member->MemberRecruitment->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'recruitments',
                    'alias' => 'Recruitment',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'MemberRecruitment.recruitment_id = Recruitment.id'
                ),
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
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Order.recruitment_id = Recruitment.id'
                )
            ),
            'fields' => array(
                'Employer.logo',
                'Employer.company_name',
                'Recruitment.title',
                'Recruitment.id',
                'Recruitment.link',
                'Recruitment.salary_min',
                'Recruitment.salary_max',
                'Recruitment.hide_salary',
                'MemberRecruitment.id',
                'MemberRecruitment.is_applied',
                'Order.expiry'
            ),
            'conditions' => array(
                //Điều kiên mặc định
                'Recruitment.is_paid' => 1,
                'Recruitment.deleted' => 0,
                'Recruitment.status' => 1,
                'Order.status' => 1,
                'Order.deleted' => 0,
                'Order.expiry >=' => $now,
                //Điều kiện
                'MemberRecruitment.member_id' => $member_id
            ),
            'limit' => 10,
            'paramType' => 'querystring',
            'order' => array(
                'MemberRecruitment.id' => 'DESC'
            )
        );
        try
        {
            $recruitments_saved = $this->paginate('MemberRecruitment');
        }
        catch (Exception $exception)
        {

        }
        //Set
        $this->set(array(
            'recruitments_saved' => $recruitments_saved,
            'title' => 'Công việc đã lưu'
        ));
    }
    function employer_view_resume()
    {
        $this->is_login_member();
        $member_id = $this->Session->read('S_Member.id');
        $members_employers = null;
//        $now = $this->get_curr_date();
        $this->Member->MemberEmployer->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'employers',
                    'alias' => 'Employer',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'MemberEmployer.employer_id = Employer.id'
                ),
            ),
            'fields' => array(
                'Employer.id',
                'Employer.logo',
                'Employer.company_name',
                'Employer.company_link',
                'MemberEmployer.id',
                'MemberEmployer.view',
                'MemberEmployer.is_saved',
                'MemberEmployer.updated',
            ),
            'conditions' => array(
                //Điều kiện
                'MemberEmployer.member_id' => $member_id
            ),
            'limit' => 10,
            'paramType' => 'querystring',
            'order' => array(
                'MemberEmployer.id' => 'DESC'
            )
        );
        try
        {
            $members_employers = $this->paginate('MemberEmployer');
            $this->Member->MemberEmployer->query('UPDATE members_employers set is_viewed_member = 1 WHERE member_id = ' . $member_id . ' AND is_viewed_member = 0');
        }
        catch (Exception $exception)
        {

        }
        //Set
        $this->set(array(
            'members_employers' => $members_employers,
            'title' => 'Các nhà tuyển dụng đã xem hồ sơ'
        ));
    }
    function get_employer_view_ajax()
    {
        $this->autoRender = false;
        $employers_view = null;
        $result = array();
        if($this->Session->check('S_Member'))
        {
            $member_id = $this->Session->read('S_Member.id');
            ClassRegistry::init('MemberEmployer')->recursive = -1;
            $employers_view = ClassRegistry::init('MemberEmployer')->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'employers',
                        'alias' => 'Employer',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberEmployer.employer_id = Employer.id'
                    ),
                ),
                'fields' => array(
                    'Employer.company_name',
                    'Employer.logo',
                    'MemberEmployer.updated',
                    'MemberEmployer.id',
                    'MemberEmployer.is_saved'
                ),
                'conditions' => array(
                    'MemberEmployer.member_id' => $member_id,
                    'MemberEmployer.is_viewed_member' => 0,
                ),
                'order' => array(
                    'MemberEmployer.updated' => 'DESC'
                )
            ));
            $result = array();
            $i = 0;
            if($employers_view)
            {
                foreach ($employers_view as $item)
                {
                    $result[$i] = array(
                        'company_name' => $item['Employer']['company_name'],
                        'logo' => $item['Employer']['logo'],
                        'id' => $item['MemberEmployer']['id'],
                        'is_saved' => $item['MemberEmployer']['is_saved'],
                        'update' => $this->Library->convert_ymd_to_dmy($item['MemberEmployer']['updated'])
                    );
                    $i = $i + 1;
                }
            }
        }
        echo json_encode($result);
    }


    function print_resume()
    {
        $this->layout = 'ajax';
        $this->Member->recursive = -1;
        $member_id = isset($this->params['member_id'])? $this->params['member_id']: '';
        $members_employers = $this->Member->find('first', array(
            'joins' => array(
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.level_id = Level.id'
                ),
                array(
                    'table' => 'provinces',
                    'alias' => 'Province',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.province_id = Province.id'
                )
            ),
            'fields' => array(
                'Member.*',
                'Level.*',
                'Province.provincename'
            ),
            'conditions' => array(
                'Member.id' => $member_id,
                'Member.allow_search' => 1
            )
        ));
        if($members_employers)
        {
            //Lấy thông tin liên quan đến hồ sơ của ứng viên
            $members_degrees = null;
            $this->Member->MemberDegree->recursive = -1;
            $members_degrees = $this->Member->MemberDegree->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'degrees',
                        'alias' => 'Degree',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberDegree.degree_id = Degree.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Degree.sort' => 'DESC'), //Để lấy bằng cao nhất vị trí [0] trong mảng
                'conditions' => array('MemberDegree.member_id' => $member_id)
            ));
            //Skill Kỹ năng
            $members_skills = null;
            $this->Member->MemberSkill->recursive = -1;
            $members_skills = $this->Member->MemberSkill->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'skills',
                        'alias' => 'Skill',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberSkill.skill_id = Skill.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('MemberSkill.member_id' => $member_id)
            ));
            //Refer tham khảo
            $refers = null;
            $this->Member->Refer->recursive = -1;
            $refers = $this->Member->Refer->find('all', array(
                'conditions' => array('member_id' => $member_id)
            ));
            //MemberLanguage
            $members_languages = null;
            $this->Member->MemberLanguage->recursive = -1;
            $members_languages = $this->Member->MemberLanguage->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'languages',
                        'alias' => 'Language',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_id = Language.id'
                    ),
                    array(
                        'table' => 'languages_levels',
                        'alias' => 'LanguageLevel',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_level_id = LanguageLevel.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Language.language_name' => 'ASC'),
                'conditions' => array('MemberLanguage.member_id' => $member_id)
            ));
            //Lịch sử làm việc
            $words = null;
            $this->Member->Work->recursive = -1;
            $words = $this->Member->Work->find('all', array(
                'conditions' => array('Work.member_id' => $member_id),
                'order' => array('Work.is_now' => 'DESC', 'Work.to' => 'DESC', 'id' => 'DESC')
            ));
            //Việc làm mong muốn
            $desires = null;
            $this->Member->Desire->recursive = -1;
            $desires = $this->Member->Desire->find('first', array(
                'joins' => array(
                    array(
                        'table' => 'levels',
                        'alias' => 'Level',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'Desire.level_id = Level.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('Desire.member_id' => $member_id)
            ));
            $desires_jobs = null;
            $desires_province = null;
            $desire_benefits = null;
            if($desires)
            {
                $desire_id = $desires['Desire']['id'];
                //Các ngành nghề mong muốn
                $this->Member->Desire->DesireJob->recursive = -1;
                $desires_jobs = $this->Member->Desire->DesireJob->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'jobs',
                            'alias' => 'Job',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireJob.job_id = Job.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireJob.desire_id' => $desire_id)
                ));
                //Nơi làm việc mong muốn
                $this->Member->Desire->DesireProvince->recursive = -1;
                $desires_province = $this->Member->Desire->DesireProvince->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'provinces',
                            'alias' => 'Province',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireProvince.province_id = Province.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireProvince.desire_id' => $desire_id)
                ));
                //Phú lợi mong muốn
                $this->Member->Desire->DesireBenefit->recursive = -1;
                $desire_benefits = $this->Member->Desire->DesireBenefit->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'benefits',
                            'alias' => 'Benefit',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireBenefit.benefit_id = Benefit.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireBenefit.desire_id' => $desire_id),
                ));
            }
            $this->set(array(
                'members' => $members_employers,
                'members_degrees' => $members_degrees,
                'members_skills' => $members_skills,
                'refers' => $refers,
                'members_languages' => $members_languages,
                'works' => $words,
                'desires' => $desires,
                'desires_jobs' => $desires_jobs,
                'desires_provinces' => $desires_province,
                'desires_benefits' => $desire_benefits,
                'title' => 'Hồ sơ ứng viên ' . $members_employers['Member']['fullname'] . ' | ' . $members_employers['Member']['title'],
            ));
        }
        else
        {
            $this->redirect($this->_base_url_employer . '/tim-ung-vien');
        }
        $this->Mpdf->init();
        $this->Mpdf->setFilename('resume.pdf');
        $this->Mpdf->setOutput('D');
    }

    //Employer
    ///////////////////////////////
    //Chi tiết ứng viên ứng tuyển
    function view_member_applied()
    {
        $this->is_login_employer();
        $this->layout = 'employer_default';
        $employer_id = $this->Session->read('S_Employer.id');
        $member_recruitment_id = isset($this->params['member_recruitment_id'])? $this->params['member_recruitment_id']: '';
        //Kiểm tra nếu ứng viên có nộp hồ sơ tin tuyển dụng thì nhà tuyển dụng mới được xem
        $this->Member->recursive = -1;
        $members_recruitments = $this->Member->find('first', array(
            'joins' => array(
                array(
                    'table' => 'members_recruitments',
                    'alias' => 'MemberRecruitment',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'MemberRecruitment.member_id = Member.id'
                ),
                array(
                    'table' => 'recruitments',
                    'alias' => 'Recruitment',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'MemberRecruitment.recruitment_id = Recruitment.id'
                ),
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.level_id = Level.id'
                ),
                array(
                    'table' => 'provinces',
                    'alias' => 'Province',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.province_id = Province.id'
                )
            ),
            'fields' => array(
                'Member.*',
                'Level.*',
                'MemberRecruitment.*',
                'Recruitment.id',
                'Recruitment.title',
                'Province.provincename'
            ),
            'conditions' => array(
                'MemberRecruitment.id' => $member_recruitment_id,
                'Recruitment.employer_id' => $employer_id
            )
        ));
        if($members_recruitments)
        {
            $member_id = $members_recruitments['Member']['id'];
            //Cập nhật đã xem ứng tuyển của ứng viên
            $this->Member->MemberRecruitment->query('UPDATE members_recruitments SET is_viewed = 1 WHERE id = ' . $member_recruitment_id);
            //Set
            //Set lại alert bell in header do đã đọc một mẫu tin
            $candidate_new = $this->get_candidate_new();
            //Cập nhật lại lượt xem hồ sơ từ công ty đến ứng viên
            $this->Member->MemberEmployer->recursive = -1;
            $count = $this->Member->MemberEmployer->find('count', array(
                'fields' => array('MemberEmployer.id'),
                'conditions' => array(
                    'MemberEmployer.member_id' => $member_id,
                    'MemberEmployer.employer_id' => $employer_id
                )
            ));
            if($count > 0)
            {
                $now = $this->get_curr_date();
                $this->Member->MemberEmployer->query("UPDATE members_employers SET view = view + 1, updated = '$now' WHERE member_id = $member_id AND employer_id =  $employer_id");
            }
            else
            {
                $this->Member->MemberEmployer->set('member_id', $member_id);
                $this->Member->MemberEmployer->set('employer_id', $employer_id);
                $this->Member->MemberEmployer->set('view', 1);
                $this->Member->MemberEmployer->set('is_saved', 0);
                $this->Member->MemberEmployer->save();
            }
            //
            //Lấy thông tin liên quan đến hồ sơ của ứng viên
            $members_degrees = null;
            $this->Member->MemberDegree->recursive = -1;
            $members_degrees = $this->Member->MemberDegree->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'degrees',
                        'alias' => 'Degree',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberDegree.degree_id = Degree.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Degree.sort' => 'DESC'), //Để lấy bằng cao nhất vị trí [0] trong mảng
                'conditions' => array('MemberDegree.member_id' => $member_id)
            ));
            //Skill Kỹ năng
            $members_skills = null;
            $this->Member->MemberSkill->recursive = -1;
            $members_skills = $this->Member->MemberSkill->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'skills',
                        'alias' => 'Skill',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberSkill.skill_id = Skill.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('MemberSkill.member_id' => $member_id)
            ));
            //Refer tham khảo
            $refers = null;
            $this->Member->Refer->recursive = -1;
            $refers = $this->Member->Refer->find('all', array(
                'conditions' => array('member_id' => $member_id)
            ));
            //MemberLanguage
            $members_languages = null;
            $this->Member->MemberLanguage->recursive = -1;
            $members_languages = $this->Member->MemberLanguage->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'languages',
                        'alias' => 'Language',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_id = Language.id'
                    ),
                    array(
                        'table' => 'languages_levels',
                        'alias' => 'LanguageLevel',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_level_id = LanguageLevel.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Language.language_name' => 'ASC'),
                'conditions' => array('MemberLanguage.member_id' => $member_id)
            ));
            //Lịch sử làm việc
            $words = null;
            $this->Member->Work->recursive = -1;
            $words = $this->Member->Work->find('all', array(
                'conditions' => array('Work.member_id' => $member_id),
                'order' => array('Work.is_now' => 'DESC', 'Work.to' => 'DESC', 'id' => 'DESC')
            ));
            //Việc làm mong muốn
            $desires = null;
            $this->Member->Desire->recursive = -1;
            $desires = $this->Member->Desire->find('first', array(
                'joins' => array(
                    array(
                        'table' => 'levels',
                        'alias' => 'Level',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'Desire.level_id = Level.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('Desire.member_id' => $member_id)
            ));
            $desires_jobs = null;
            $desires_province = null;
            $desire_benefits = null;
            if($desires)
            {
                $desire_id = $desires['Desire']['id'];
                //Các ngành nghề mong muốn
                $this->Member->Desire->DesireJob->recursive = -1;
                $desires_jobs = $this->Member->Desire->DesireJob->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'jobs',
                            'alias' => 'Job',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireJob.job_id = Job.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireJob.desire_id' => $desire_id)
                ));
                //Nơi làm việc mong muốn
                $this->Member->Desire->DesireProvince->recursive = -1;
                $desires_province = $this->Member->Desire->DesireProvince->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'provinces',
                            'alias' => 'Province',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireProvince.province_id = Province.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireProvince.desire_id' => $desire_id)
                ));
                //Phú lợi mong muốn
                $this->Member->Desire->DesireBenefit->recursive = -1;
                $desire_benefits = $this->Member->Desire->DesireBenefit->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'benefits',
                            'alias' => 'Benefit',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireBenefit.benefit_id = Benefit.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireBenefit.desire_id' => $desire_id),
                ));
            }
            //Danh sách trạng thái hồ sơ
            $status = null;
            ClassRegistry::init('RecruitmentStatus')->recursive = -1;
            $status = ClassRegistry::init('RecruitmentStatus')->find('all');
            //Số lượt xem hồ sơ (Tất cả nhà tuyển dụng)
            $this->Member->MemberEmployer->recursive = -1;
            $view_resume = $this->Member->MemberEmployer->find('first', array(
                'fields' => array('SUM(`MemberEmployer`.`view`) AS sum_view '),
                'conditions' => array('MemberEmployer.member_id' => $member_id)
            ));
            $this->Member->MemberEmployer->recursive = -1;
            $count_is_saved_resume = $this->Member->MemberEmployer->find('count', array(
                'conditions' => array(
                    'employer_id' => $employer_id,
                    'member_id' => $member_id,
                    'is_saved' => 1
                )
            ));
            $is_saved_resume = false;
            if($count_is_saved_resume > 0)
            {
                $is_saved_resume = true;
            }
            //Cập nhật lại lượt xem tổng trên bảng members
            $this->_update_view_all_member($member_id, $view_resume[0]['sum_view']);
            $this->set(array(
                'candidate_new' => $candidate_new,
                'members_recruitments' => $members_recruitments,
                'members_degrees' => $members_degrees,
                'members_skills' => $members_skills,
                'refers' => $refers,
                'members_languages' => $members_languages,
                'works' => $words,
                'desires' => $desires,
                'desires_jobs' => $desires_jobs,
                'desires_provinces' => $desires_province,
                'desires_benefits' => $desire_benefits,
                'sum_view_resume' => $view_resume[0]['sum_view'],
                'is_saved_resume' => $is_saved_resume,
                'status' => $status,
                'title' => 'Hồ sơ ứng viên ' . $members_recruitments['Member']['fullname'] . ' | ' . $members_recruitments['Member']['title'],
            ));
        }
        else
        {
            $this->redirect($this->_base_url_employer . '/ho-so-ung-vien');
        }
    }
    //Chi tiết ứng viên đã lưu hồ sơ
    function view_resume_saved()
    {
        $this->is_login_employer();
        $this->layout = 'employer_default';
        $employer_id = $this->Session->read('S_Employer.id');
        $member_employer_id = isset($this->params['member_employer_id'])? $this->params['member_employer_id']: '';
        //Kiểm tra nếu nhà tuyển dụng có lưu hồ sơ mới được xem
        $this->Member->recursive = -1;
        $members_employers = $this->Member->find('first', array(
            'joins' => array(
                array(
                    'table' => 'members_employers',
                    'alias' => 'MemberEmployer',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'MemberEmployer.member_id = Member.id'
                ),
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.level_id = Level.id'
                ),
                array(
                    'table' => 'provinces',
                    'alias' => 'Province',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.province_id = Province.id'
                )
            ),
            'fields' => array(
                'Member.*',
                'Level.*',
                'MemberEmployer.*',
                'Province.provincename'
            ),
            'conditions' => array(
                'MemberEmployer.id' => $member_employer_id,
                'MemberEmployer.employer_id' => $employer_id
            )
        ));
        if($members_employers)
        {
            $member_id = $members_employers['Member']['id'];
            //Set
            //Cập nhật lại lượt xem hồ sơ từ công ty đến ứng viên
            $this->Member->MemberEmployer->recursive = -1;
            $count = $this->Member->MemberEmployer->find('count', array(
                'fields' => array('MemberEmployer.id'),
                'conditions' => array(
                    'MemberEmployer.member_id' => $member_id,
                    'MemberEmployer.employer_id' => $employer_id
                )
            ));
            if($count > 0)
            {
                $now = $this->get_curr_date();
                $this->Member->MemberEmployer->query("UPDATE members_employers SET view = view + 1, updated = '$now' WHERE member_id = $member_id AND employer_id =  $employer_id");
            }
            else
            {
                $this->Member->MemberEmployer->set('member_id', $member_id);
                $this->Member->MemberEmployer->set('employer_id', $employer_id);
                $this->Member->MemberEmployer->set('view', 1);
                $this->Member->MemberEmployer->set('is_saved', 0);
                $this->Member->MemberEmployer->save();
            }
            //
            //Lấy thông tin liên quan đến hồ sơ của ứng viên
            $members_degrees = null;
            $this->Member->MemberDegree->recursive = -1;
            $members_degrees = $this->Member->MemberDegree->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'degrees',
                        'alias' => 'Degree',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberDegree.degree_id = Degree.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Degree.sort' => 'DESC'), //Để lấy bằng cao nhất vị trí [0] trong mảng
                'conditions' => array('MemberDegree.member_id' => $member_id)
            ));
            //Skill Kỹ năng
            $members_skills = null;
            $this->Member->MemberSkill->recursive = -1;
            $members_skills = $this->Member->MemberSkill->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'skills',
                        'alias' => 'Skill',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberSkill.skill_id = Skill.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('MemberSkill.member_id' => $member_id)
            ));
            //Refer tham khảo
            $refers = null;
            $this->Member->Refer->recursive = -1;
            $refers = $this->Member->Refer->find('all', array(
                'conditions' => array('member_id' => $member_id)
            ));
            //MemberLanguage
            $members_languages = null;
            $this->Member->MemberLanguage->recursive = -1;
            $members_languages = $this->Member->MemberLanguage->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'languages',
                        'alias' => 'Language',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_id = Language.id'
                    ),
                    array(
                        'table' => 'languages_levels',
                        'alias' => 'LanguageLevel',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_level_id = LanguageLevel.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Language.language_name' => 'ASC'),
                'conditions' => array('MemberLanguage.member_id' => $member_id)
            ));
            //Lịch sử làm việc
            $words = null;
            $this->Member->Work->recursive = -1;
            $words = $this->Member->Work->find('all', array(
                'conditions' => array('Work.member_id' => $member_id),
                'order' => array('Work.is_now' => 'DESC', 'Work.to' => 'DESC', 'id' => 'DESC')
            ));
            //Việc làm mong muốn
            $desires = null;
            $this->Member->Desire->recursive = -1;
            $desires = $this->Member->Desire->find('first', array(
                'joins' => array(
                    array(
                        'table' => 'levels',
                        'alias' => 'Level',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'Desire.level_id = Level.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('Desire.member_id' => $member_id)
            ));
            $desires_jobs = null;
            $desires_province = null;
            $desire_benefits = null;
            if($desires)
            {
                $desire_id = $desires['Desire']['id'];
                //Các ngành nghề mong muốn
                $this->Member->Desire->DesireJob->recursive = -1;
                $desires_jobs = $this->Member->Desire->DesireJob->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'jobs',
                            'alias' => 'Job',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireJob.job_id = Job.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireJob.desire_id' => $desire_id)
                ));
                //Nơi làm việc mong muốn
                $this->Member->Desire->DesireProvince->recursive = -1;
                $desires_province = $this->Member->Desire->DesireProvince->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'provinces',
                            'alias' => 'Province',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireProvince.province_id = Province.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireProvince.desire_id' => $desire_id)
                ));
                //Phú lợi mong muốn
                $this->Member->Desire->DesireBenefit->recursive = -1;
                $desire_benefits = $this->Member->Desire->DesireBenefit->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'benefits',
                            'alias' => 'Benefit',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireBenefit.benefit_id = Benefit.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireBenefit.desire_id' => $desire_id),
                ));
            }
            //Danh sách trạng thái hồ sơ
            $status = null;
            ClassRegistry::init('RecruitmentStatus')->recursive = -1;
            $status = ClassRegistry::init('RecruitmentStatus')->find('all');
            //Số lượt xem hồ sơ (Tất cả nhà tuyển dụng)
            $this->Member->MemberEmployer->recursive = -1;
            $view_resume = $this->Member->MemberEmployer->find('first', array(
                'fields' => array('SUM(`MemberEmployer`.`view`) AS sum_view '),
                'conditions' => array('MemberEmployer.member_id' => $member_id)
            ));
            $this->Member->MemberEmployer->recursive = -1;
            $count_is_saved_resume = $this->Member->MemberEmployer->find('count', array(
                'conditions' => array(
                    'employer_id' => $employer_id,
                    'member_id' => $member_id,
                    'is_saved' => 1
                )
            ));
            $is_saved_resume = false;
            if($count_is_saved_resume > 0)
            {
                $is_saved_resume = true;
            }
            //Cập nhật lại lượt xem tổng trên bảng members
            $this->_update_view_all_member($member_id, $view_resume[0]['sum_view']);
            $this->set(array(
                'members_employers' => $members_employers,
                'members_degrees' => $members_degrees,
                'members_skills' => $members_skills,
                'refers' => $refers,
                'members_languages' => $members_languages,
                'works' => $words,
                'desires' => $desires,
                'desires_jobs' => $desires_jobs,
                'desires_provinces' => $desires_province,
                'desires_benefits' => $desire_benefits,
                'sum_view_resume' => $view_resume[0]['sum_view'],
                'is_saved_resume' => $is_saved_resume,
                'status' => $status,
                'title' => 'Hồ sơ ứng viên ' . $members_employers['Member']['fullname'] . ' | ' . $members_employers['Member']['title'],
            ));
        }
        else
        {
            $this->redirect($this->_base_url_employer . '/ho-so-ung-vien');
        }
    }
    //Chi tiết ứng viên tìm kiếm hồ sơ
    function view_resume_search()
    {
        $this->is_login_employer();
        $this->layout = 'employer_default';
        $employer_id = $this->Session->read('S_Employer.id');
        $member_id = isset($this->params['member_id'])? $this->params['member_id']: '';
        //Kiểm tra sự tồn tại của member_id trước khi lưu
        $this->Member->recursive = -1;
        $count_members = $this->Member->find('count', array(
            'fields' => array('Member.id'),
            'conditions' => array(
                'id' => $member_id,
                'allow_search' => 1
            )
        ));
        if($count_members <= 0)
        {
            $this->redirect('/nha-tuyen-dung/tim-ung-vien');
        }
        //Cập nhật lại lượt xem hồ sơ từ công ty đến ứng viên
        $this->Member->MemberEmployer->recursive = -1;
        $count = $this->Member->MemberEmployer->find('count', array(
            'fields' => array('MemberEmployer.id'),
            'conditions' => array(
                'MemberEmployer.member_id' => $member_id,
                'MemberEmployer.employer_id' => $employer_id
            )
        ));
        if($count > 0)
        {
            $now = $this->get_curr_date();
            $this->Member->MemberEmployer->query("UPDATE members_employers SET view = view + 1, updated = '$now' WHERE member_id = $member_id AND employer_id =  $employer_id");
        }
        else
        {
            $this->Member->MemberEmployer->set('member_id', $member_id);
            $this->Member->MemberEmployer->set('employer_id', $employer_id);
            $this->Member->MemberEmployer->set('view', 1);
            $this->Member->MemberEmployer->set('is_saved', 0);
            $this->Member->MemberEmployer->save();
        }
        //
        //

        $members_employers = $this->Member->find('first', array(
            'joins' => array(
                array(
                    'table' => 'members_employers',
                    'alias' => 'MemberEmployer',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'MemberEmployer.member_id = Member.id'
                ),
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.level_id = Level.id'
                ),
                array(
                    'table' => 'provinces',
                    'alias' => 'Province',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.province_id = Province.id'
                )
            ),
            'fields' => array(
                'Member.*',
                'Level.*',
                'MemberEmployer.*',
                'Province.provincename'
            ),
            'conditions' => array(
                'Member.id' => $member_id,
                'Member.allow_search' => 1
            )
        ));
        if($members_employers)
        {
            //Lấy thông tin liên quan đến hồ sơ của ứng viên
            $members_degrees = null;
            $this->Member->MemberDegree->recursive = -1;
            $members_degrees = $this->Member->MemberDegree->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'degrees',
                        'alias' => 'Degree',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberDegree.degree_id = Degree.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Degree.sort' => 'DESC'), //Để lấy bằng cao nhất vị trí [0] trong mảng
                'conditions' => array('MemberDegree.member_id' => $member_id)
            ));
            //Skill Kỹ năng
            $members_skills = null;
            $this->Member->MemberSkill->recursive = -1;
            $members_skills = $this->Member->MemberSkill->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'skills',
                        'alias' => 'Skill',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberSkill.skill_id = Skill.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('MemberSkill.member_id' => $member_id)
            ));
            //Refer tham khảo
            $refers = null;
            $this->Member->Refer->recursive = -1;
            $refers = $this->Member->Refer->find('all', array(
                'conditions' => array('member_id' => $member_id)
            ));
            //MemberLanguage
            $members_languages = null;
            $this->Member->MemberLanguage->recursive = -1;
            $members_languages = $this->Member->MemberLanguage->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'languages',
                        'alias' => 'Language',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_id = Language.id'
                    ),
                    array(
                        'table' => 'languages_levels',
                        'alias' => 'LanguageLevel',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_level_id = LanguageLevel.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Language.language_name' => 'ASC'),
                'conditions' => array('MemberLanguage.member_id' => $member_id)
            ));
            //Lịch sử làm việc
            $words = null;
            $this->Member->Work->recursive = -1;
            $words = $this->Member->Work->find('all', array(
                'conditions' => array('Work.member_id' => $member_id),
                'order' => array('Work.is_now' => 'DESC', 'Work.to' => 'DESC', 'id' => 'DESC')
            ));
            //Việc làm mong muốn
            $desires = null;
            $this->Member->Desire->recursive = -1;
            $desires = $this->Member->Desire->find('first', array(
                'joins' => array(
                    array(
                        'table' => 'levels',
                        'alias' => 'Level',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'Desire.level_id = Level.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('Desire.member_id' => $member_id)
            ));
            $desires_jobs = null;
            $desires_province = null;
            $desire_benefits = null;
            if($desires)
            {
                $desire_id = $desires['Desire']['id'];
                //Các ngành nghề mong muốn
                $this->Member->Desire->DesireJob->recursive = -1;
                $desires_jobs = $this->Member->Desire->DesireJob->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'jobs',
                            'alias' => 'Job',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireJob.job_id = Job.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireJob.desire_id' => $desire_id)
                ));
                //Nơi làm việc mong muốn
                $this->Member->Desire->DesireProvince->recursive = -1;
                $desires_province = $this->Member->Desire->DesireProvince->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'provinces',
                            'alias' => 'Province',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireProvince.province_id = Province.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireProvince.desire_id' => $desire_id)
                ));
                //Phú lợi mong muốn
                $this->Member->Desire->DesireBenefit->recursive = -1;
                $desire_benefits = $this->Member->Desire->DesireBenefit->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'benefits',
                            'alias' => 'Benefit',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireBenefit.benefit_id = Benefit.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireBenefit.desire_id' => $desire_id),
                ));
            }
            //Danh sách trạng thái hồ sơ
            $status = null;
            ClassRegistry::init('RecruitmentStatus')->recursive = -1;
            $status = ClassRegistry::init('RecruitmentStatus')->find('all');
            //Số lượt xem hồ sơ (Tất cả nhà tuyển dụng)
            $this->Member->MemberEmployer->recursive = -1;
            $view_resume = $this->Member->MemberEmployer->find('first', array(
                'fields' => array('SUM(`MemberEmployer`.`view`) AS sum_view '),
                'conditions' => array('MemberEmployer.member_id' => $member_id)
            ));
            $this->Member->MemberEmployer->recursive = -1;
            $count_is_saved_resume = $this->Member->MemberEmployer->find('count', array(
                'conditions' => array(
                    'employer_id' => $employer_id,
                    'member_id' => $member_id,
                    'is_saved' => 1
                )
            ));
            $is_saved_resume = false;
            if($count_is_saved_resume > 0)
            {
                $is_saved_resume = true;
            }
            //Cập nhật lại lượt xem tổng trên bảng members
            $this->_update_view_all_member($member_id, $view_resume[0]['sum_view']);
            $this->set(array(
                'members_employers' => $members_employers,
                'members_degrees' => $members_degrees,
                'members_skills' => $members_skills,
                'refers' => $refers,
                'members_languages' => $members_languages,
                'works' => $words,
                'desires' => $desires,
                'desires_jobs' => $desires_jobs,
                'desires_provinces' => $desires_province,
                'desires_benefits' => $desire_benefits,
                'sum_view_resume' => $view_resume[0]['sum_view'],
                'is_saved_resume' => $is_saved_resume,
                'status' => $status,
                'title' => 'Hồ sơ ứng viên ' . $members_employers['Member']['fullname'] . ' | ' . $members_employers['Member']['title'],
            ));
        }
        else
        {
            $this->redirect($this->_base_url_employer . '/tim-ung-vien');
        }
    }
    //Trang tìm ứng viên
    function search_resume()
    {
        $this->layout = 'employer_default';
        $this->is_login_employer();
        $current_now = getdate();
        $current_year = $current_now['year'];
        //Search
        $url = $this->params['url'];
        $s_arr_jobs = isset($url['s_jobs'])  && $url['s_jobs'] != ''? $url['s_jobs']: null;
        $s_arr_provinces = isset($url['s_provinces']) && $url['s_provinces'] != ''? $url['s_provinces']: null;
        //Level
        $s_level = isset($url['s_level'])? $url['s_level']: '';
        $condition_level = '';
        if($s_level != '')
        {
            $condition_level = 'Desire.level_id = ' . $s_level;
        }
        //title
        $s_title = isset($url['title'])? $url['title']: '';
        $condition_title = '';
        if($s_title != '')
        {
            $condition_title = "Member.title LIKE '%$s_title%'";
        }
        //Salary min
        $s_salary_min = isset($url['s_salary_min'])? $url['s_salary_min']: '';
        $condition_salary_min = '';
        if($s_salary_min != '')
        {
            $condition_salary_min = 'Desire.salary >= ' . str_replace(',', '', $s_salary_min);
        }
        //Salary Max
        $s_salary_max = isset($url['s_salary_max'])? $url['s_salary_max']: '';
        $condition_salary_max = '';
        if($s_salary_max != '')
        {
            $condition_salary_max = 'Desire.salary <= ' . str_replace(',', '', $s_salary_max);
        }
        //Age min
        $s_age_min = isset($url['s_age_min'])? $url['s_age_min']: '';
        $condition_age_min = '';
        if($s_age_min != '')
        {
            $condition_age_min = 'YEAR(Member.birthday) <= ' . ($current_year - $s_age_min);
        }
        //Age Max
        $s_age_max = isset($url['s_age_max'])? $url['s_age_max']: '';
        $condition_age_max = '';
        if($s_age_max != '')
        {
            $condition_age_max = 'YEAR(Member.birthday) >= ' . ($current_year - $s_age_max);
        }
        //Experience
        $s_experience = isset($url['s_experience'])? $url['s_experience']: '';
        $condition_experience = '';
        if($s_experience != '')
        {
            $condition_experience = 'Member.experience = ' . $s_experience;
        }
        //Gender
        $s_gender = isset($url['s_gender'])? $url['s_gender']: '';
        $condition_gender = '';
        if($s_gender != '')
        {
            $condition_gender = 'Member.gender = ' . $s_gender;
        }

        //Lọc mảng các member_id theo job và province mong muốn trước
        $condition_arr_jobs = '';
        if($s_arr_jobs != null)
        {
            $condition_arr_jobs = 'DesireJob.job_id IN (' . implode($s_arr_jobs, ',') . ')';
        }
        $condition_arr_provinces = '';
        if($s_arr_provinces != null)
        {
            $condition_arr_provinces = 'DesireProvince.province_id IN (' . implode($s_arr_provinces, ',') . ')';
        }
        $arr_id_member = null;
        ClassRegistry::init('Desire')->recursive = -1;
        $arr_id_member = ClassRegistry::init('Desire')->find('all', array(
            'joins' => array(
                array(
                    'table' => 'desires_jobs',
                    'alias' => 'DesireJob',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Desire.id = DesireJob.desire_id'
                ),
                array(
                    'table' => 'desires_provinces',
                    'alias' => 'DesireProvince',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Desire.id = DesireProvince.desire_id'
                )
            ),
            'fields' => array(
                'DISTINCT Desire.member_id',
            ),
            'conditions' => array(
                $condition_arr_jobs,
                $condition_arr_provinces
            )
        ));
        $condition_arr_member = '';
        if($arr_id_member)
        {
            $i = 0;
            foreach ($arr_id_member as $item)
            {
                $arr_id_member2[$i] = $item['Desire']['member_id'];
                $i = $i + 1;
            }
            $condition_arr_member = 'Member.id IN (' . implode($arr_id_member2, ',') . ')';
        }
        else
        {
            $condition_arr_member = 'Member.id IS NULL';
        }
        $members_resumes = null;
        $this->Member->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'desires',
                    'alias' => 'Desire',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Member.id = Desire.member_id'
                ),
            ),
            'fields' => array(
                'Member.fullname',
                'Member.id',
                'Member.title',
                'Member.experience',
                'Member.f_profile',
                'Member.count_download',
                'Member.view',
                'Member.lastlogin',

                'Desire.salary',
                'Desire.id'
            ),
            'conditions' => array(
                //Điều kiện mặc định
                'Member.allow_search' => 1,

                //Điều kiện tìm kiếm
                $condition_arr_member,
                $condition_level,
                $condition_title,
                $condition_salary_min,
                $condition_salary_max,
                $condition_experience,
                $condition_gender,
                $condition_age_min,
                $condition_age_max
            ),
            'limit' => 10,
            'order' => array(

            ),
            'paramType' => 'querystring'
        );
        try
        {
            $members_resumes = $this->paginate('Member');
            if($members_resumes)
            {
                $m = 0;
                foreach ($members_resumes as $item)
                {
                    $this->Member->Desire->DesireJob->recursive = -1;
                    $desires_jobs = $this->Member->Desire->DesireJob->find('all', array(
                        'joins' => array(
                            array(
                                'table' => 'jobs',
                                'alias' => 'Job',
                                'type' => 'INNER',
                                'foreignKey' => false,
                                'conditions' => 'DesireJob.job_id = Job.id'
                            )
                        ),
                        'fields' => array(
                            'Job.jobname'
                        ),
                        'conditions' => array('DesireJob.desire_id' => $item['Desire']['id'])
                    ));
                    if($desires_jobs)
                    {
                        $members_resumes[$m]['DesireJob'] = $desires_jobs;
                    }
                    $this->Member->Desire->DesireProvince->recursive = -1;
                    $desires_provinces = $this->Member->Desire->DesireProvince->find('all', array(
                        'joins' => array(
                            array(
                                'table' => 'provinces',
                                'alias' => 'Province',
                                'type' => 'INNER',
                                'foreignKey' => false,
                                'conditions' => 'DesireProvince.province_id = Province.id'
                            )
                        ),
                        'fields' => array(
                            'Province.provincename'
                        ),
                        'conditions' => array('DesireProvince.desire_id' => $item['Desire']['id'])
                    ));
                    if($desires_provinces)
                    {
                        $members_resumes[$m]['DesireProvince'] = $desires_provinces;
                    }
                    $m = $m + 1;
                }
            }
//            debug($members_resumes);
        }
        catch (Exception $exception)
        {
//
        }
        //Get job
        $Job = new JobsController();
        $jobs = $Job->_get_jobs_option();
        $Province = new ProvincesController();
        $provinces = $Province->_get_province_option();
        $Level = new LevelsController();
        $levels = $Level->_get_levels_option();
        //Set
        $this->set(array(
            'members_resumes' => $members_resumes,
            'jobs' => $jobs,
            'provinces' => $provinces,
            'levels' => $levels,
            'title' => 'Tìm ứng viên',
            //Trả về dữ liệu tìm kiếm
            's_level' => $s_level,
            's_jobs_selected' => $s_arr_jobs,
            's_provinces_selected' => $s_arr_provinces,
            's_title' => $s_title,
            's_experience' => $s_experience,
            's_salary_min' => $s_salary_min,
            's_salary_max' => $s_salary_max,
            's_age_min' => $s_age_min,
            's_age_max' => $s_age_max,
            's_gender' => $s_gender
        ));
    }
    //Cập nhật lại lượt xem của tất cả các công ty trên bảng members
    function _update_view_all_member($member_id, $view)
    {
        $this->Member->query('UPDATE members SET view = ' . $view . ' WHERE id = ' . $member_id);
    }

    //Admin
    ///////////////////////////////
    public function admin_index()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        //Search
        $url = $this->params['url'];
        //name
        $name = isset($url['name'])? $url['name']: '';
        $condition_email = '';
        $condition_username = '';
        if($name != '')
        {
            $condition_email = 'Member.email = "' . $name . '"';
            $condition_username = 'Member.fullname LIKE "%' . $name . '%"';
        }

        $this->Member->recursive = -1;
        $this->paginate = array(
            'paramType' => 'querystring',
            'limit' => 5,
            'joins' => array(
                array(
                    'table' => 'provinces',
                    'alias' => 'Province',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('Province.id = Member.province_id'),
                ),
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('Member.level_id = Level.id'),
                ),
            ),
            'fields' =>'*',
            'order' => array('Member.id' => 'desc'),
            'conditions' => array(
                'OR' => array(
                    $condition_email,
                    $condition_username
                )
            )
        );
        $members = $this->paginate('Member');
        $this->set(array(
            'members' => $members,
            'title' => 'Danh sách thành viên',
        ));
    }
    public function admin_view_detail($id = '')
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $this->Member->recursive = -1;
        $members = $this->Member->find('first', array(
            'joins' => array(
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.level_id = Level.id'
                ),
                array(
                    'table' => 'provinces',
                    'alias' => 'Province',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.province_id = Province.id'
                )
            ),
            'fields' => array('*'),
            'conditions' => array(
                'Member.id' => $id
            ),
        ));
        if(!$members)
        {
            $this->redirect('/admin/members');
        }

        $this->set(array(
            'title' => 'Thông tin thành viên',
            'members' => $members,
        ));
    }
    function admin_view_resume($member_id = '')
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $this->Member->recursive = -1;
        $members = $this->Member->find('first', array(
            'joins' => array(
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.level_id = Level.id'
                ),
                array(
                    'table' => 'provinces',
                    'alias' => 'Province',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Member.province_id = Province.id'
                )
            ),
            'fields' => array(
                'Member.*',
                'Level.*',
                'Province.provincename'
            ),
            'conditions' => array(
                'Member.id' => $member_id,
            )
        ));
        if($members)
        {
            //Lấy thông tin liên quan đến hồ sơ của ứng viên
            $members_degrees = null;
            $this->Member->MemberDegree->recursive = -1;
            $members_degrees = $this->Member->MemberDegree->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'degrees',
                        'alias' => 'Degree',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberDegree.degree_id = Degree.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Degree.sort' => 'DESC'), //Để lấy bằng cao nhất vị trí [0] trong mảng
                'conditions' => array('MemberDegree.member_id' => $member_id)
            ));
            //Skill Kỹ năng
            $members_skills = null;
            $this->Member->MemberSkill->recursive = -1;
            $members_skills = $this->Member->MemberSkill->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'skills',
                        'alias' => 'Skill',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberSkill.skill_id = Skill.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('MemberSkill.member_id' => $member_id)
            ));
            //Refer tham khảo
            $refers = null;
            $this->Member->Refer->recursive = -1;
            $refers = $this->Member->Refer->find('all', array(
                'conditions' => array('member_id' => $member_id)
            ));
            //MemberLanguage
            $members_languages = null;
            $this->Member->MemberLanguage->recursive = -1;
            $members_languages = $this->Member->MemberLanguage->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'languages',
                        'alias' => 'Language',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_id = Language.id'
                    ),
                    array(
                        'table' => 'languages_levels',
                        'alias' => 'LanguageLevel',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberLanguage.language_level_id = LanguageLevel.id'
                    )
                ),
                'fields' => array('*'),
                'order' => array('Language.language_name' => 'ASC'),
                'conditions' => array('MemberLanguage.member_id' => $member_id)
            ));
            //Lịch sử làm việc
            $words = null;
            $this->Member->Work->recursive = -1;
            $words = $this->Member->Work->find('all', array(
                'conditions' => array('Work.member_id' => $member_id),
                'order' => array('Work.is_now' => 'DESC', 'Work.to' => 'DESC', 'id' => 'DESC')
            ));
            //Việc làm mong muốn
            $desires = null;
            $this->Member->Desire->recursive = -1;
            $desires = $this->Member->Desire->find('first', array(
                'joins' => array(
                    array(
                        'table' => 'levels',
                        'alias' => 'Level',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'Desire.level_id = Level.id'
                    )
                ),
                'fields' => array('*'),
                'conditions' => array('Desire.member_id' => $member_id)
            ));
            $desires_jobs = null;
            $desires_province = null;
            $desire_benefits = null;
            if($desires)
            {
                $desire_id = $desires['Desire']['id'];
                //Các ngành nghề mong muốn
                $this->Member->Desire->DesireJob->recursive = -1;
                $desires_jobs = $this->Member->Desire->DesireJob->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'jobs',
                            'alias' => 'Job',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireJob.job_id = Job.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireJob.desire_id' => $desire_id)
                ));
                //Nơi làm việc mong muốn
                $this->Member->Desire->DesireProvince->recursive = -1;
                $desires_province = $this->Member->Desire->DesireProvince->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'provinces',
                            'alias' => 'Province',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireProvince.province_id = Province.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireProvince.desire_id' => $desire_id)
                ));
                //Phú lợi mong muốn
                $this->Member->Desire->DesireBenefit->recursive = -1;
                $desire_benefits = $this->Member->Desire->DesireBenefit->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'benefits',
                            'alias' => 'Benefit',
                            'type' => 'INNER',
                            'foreignKey' => false,
                            'conditions' => 'DesireBenefit.benefit_id = Benefit.id'
                        )
                    ),
                    'fields' => array('*'),
                    'conditions' => array('DesireBenefit.desire_id' => $desire_id),
                ));
            }
            //Số lượt xem hồ sơ (Tất cả nhà tuyển dụng)
            $this->Member->MemberEmployer->recursive = -1;
            $view_resume = $this->Member->MemberEmployer->find('first', array(
                'fields' => array('SUM(`MemberEmployer`.`view`) AS sum_view '),
                'conditions' => array('MemberEmployer.member_id' => $member_id)
            ));
            $this->set(array(
                'members' => $members,
                'members_degrees' => $members_degrees,
                'members_skills' => $members_skills,
                'refers' => $refers,
                'members_languages' => $members_languages,
                'works' => $words,
                'desires' => $desires,
                'desires_jobs' => $desires_jobs,
                'desires_provinces' => $desires_province,
                'desires_benefits' => $desire_benefits,
                'sum_view_resume' => $view_resume[0]['sum_view'],
                'title' => 'Hồ sơ ứng viên ' . $members['Member']['fullname'] . ' | ' . $members['Member']['title'],
            ));
        }
        else
        {
            $this->redirect($this->_base_url_employer . '/admin/members');
        }
    }
    function admin_disactive()
    {
        $this->autoRender = false;
        if($this->Session->check('Admin'))
        {
            $member_id = $this->request->data['member_id'];
            $this->Member->recursive = -1;
            if($this->Member->updateAll(array('Member.status' => 0), array('Member.id' => $member_id)))
            {
                $this->Session->setFlash('Đã khóa tài khoản', 'flashSuccess');
            }
            else
            {
                $this->Session->setFlash('Lỗi', 'flashError');
            }
        }
    }
    function admin_active()
    {
        $this->autoRender = false;
        if($this->Session->check('Admin'))
        {
            $member_id = $this->request->data['member_id'];
            $this->Member->recursive = -1;
            if($this->Member->updateAll(array('Member.status' => 1), array('Member.id' => $member_id)))
            {
                $this->Session->setFlash('Đã mở khóa tài khoản', 'flashSuccess');
            }
            else
            {
                $this->Session->setFlash('Lỗi', 'flashError');
            }
        }
    }
}