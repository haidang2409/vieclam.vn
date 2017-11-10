<?php
App::uses('AppController', 'Controller');
App::uses('JobsController', 'Controller');
App::uses('ProvincesController', 'Controller');
App::uses('RecruitmentsLanguagesController', 'Controller');
class RecruitmentsController extends AppController
{
    //Import
    //User
    ////////////////////////
    function index()
    {
        $this->layout = 'default_index';
        $Job = new JobsController();
        $jobs = $Job->_get_jobs_option_link();
        $Province = new ProvincesController();
        $provinces = $Province->_get_province_option_link();
        //Set
        $this->set(array(
            'jobs' => $jobs,
            'provinces' => $provinces
        ));
    }
    function index_recruitment()
    {
        //Điều kiện
        $url = $this->params['url'];
        //Job và Province
        $s_job_id = isset($this->params['job_id'])? substr($this->params['job_id'], 1): '';
        $s_job_link = isset($this->params['job_link'])? $this->params['job_link']: '';
        $s_province_id = isset($this->params['province_id'])? substr($this->params['province_id'], 1): '';
        $s_province_link = isset($this->params['province_link'])? $this->params['province_link']: '';
        $arr_id_recruitment = null; //Mảng các recruitment_id nếu có tìm theo job_id hoặc province_id
        $condition_id_recruitment = '';//Điều kiện WHERE IN recruitment_id
        //Nếu có tìm theo job và province
        if($s_job_id != '' && $s_province_id != '')
        {
            $this->Recruitment->RecruitmentJob->recursive = -1;
            $data_jobs_and_province = $this->Recruitment->RecruitmentJob->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'recruitments_provinces',
                        'alias' => 'RecruitmentProvince',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'RecruitmentJob.recruitment_id = RecruitmentProvince.recruitment_id'
                    )
                ),
                'conditions' => array(
                    'RecruitmentJob.job_id' => $s_job_id,
                    'RecruitmentProvince.province_id' => $s_province_id
                ),
                'order' => 'RecruitmentJob.recruitment_id',
                'fields' => array('DISTINCT RecruitmentJob.recruitment_id')
            ));
            if($data_jobs_and_province)
            {
                $m = 0;
                foreach ($data_jobs_and_province as $item)
                {
                    $arr_id_recruitment[$m] = $item['RecruitmentJob']['recruitment_id'];
                    $m = $m + 1;
                }
                $condition_id_recruitment = 'Recruitment.id IN (' . implode(',', $arr_id_recruitment) . ')';
            }
            else
            {
                $condition_id_recruitment = 'Recruitment.id IS NULL';
            }
        }
        else
        {
            //Nếu chỉ tìm theo job
            if($s_job_id != '')
            {
                $this->Recruitment->RecruitmentJob->recursive = -1;
                $data_jobs = $this->Recruitment->RecruitmentJob->find('all', array(
                    'conditions' => array('RecruitmentJob.job_id' => $s_job_id),
                    'order' => 'RecruitmentJob.recruitment_id',
                    'fields' => array('DISTINCT RecruitmentJob.recruitment_id')
                ));
                if($data_jobs)
                {
                    $m = 0;
                    foreach ($data_jobs as $item)
                    {
                        $arr_id_recruitment[$m] = $item['RecruitmentJob']['recruitment_id'];
                        $m = $m + 1;
                    }
                    $condition_id_recruitment = 'Recruitment.id IN (' . implode(',', $arr_id_recruitment) . ')';
                }
                else
                {
                    $condition_id_recruitment = 'Recruitment.id IS NULL';
                }
            }
            else
            {
                //Nếu chỉ tìm theo province
                if($s_province_id != '')
                {
                    $this->Recruitment->RecruitmentProvince->recursive = -1;
                    $data_provinces = $this->Recruitment->RecruitmentProvince->find('all', array(
                        'conditions' => array('RecruitmentProvince.province_id' => $s_province_id),
                        'order' => 'RecruitmentProvince.recruitment_id',
                        'fields' => array('DISTINCT RecruitmentProvince.recruitment_id')
                    ));
                    if($data_provinces)
                    {
                        $m = 0;
                        foreach ($data_provinces as $item)
                        {
                            $arr_id_recruitment[$m] = $item['RecruitmentProvince']['recruitment_id'];
                            $m = $m + 1;
                        }
                        $condition_id_recruitment = 'Recruitment.id IN (' . implode(',', $arr_id_recruitment) . ')';
                    }
                    else
                    {
                        $condition_id_recruitment = 'Recruitment.id IS NULL';
                    }
                }
            }
        }
        //
        //Employer
        $s_employer = isset($this->params['company_id'])? $this->params['company_id']: '';
        $condition_employer = '';
        if($s_employer != '')
        {
            $condition_employer = 'Employer.id = ' . $s_employer;
        }
        //Key
        $s_key = isset($url['key_word'])? $url['key_word']: '';
        $condition_key = '';
        if($s_key != '')
        {
            $condition_key = 'Recruitment.title LIKE "%' . $s_key . '%"';
        }
        //Level (Chức vụ)
        $s_level_id = isset($url['level'])? $url['level']: '';
        $condition_level = '';
        if($s_level_id != '')
        {
            $condition_level = 'Recruitment.level_id = ' . $s_level_id;
        }
        //Salary
        $s_salary_string = isset($url['salary'])? $url['salary']: '';
        $s_salary_min = 0;
        $s_salary_max = 0;
        $condition_salary = '';
        if($s_salary_string != '')
        {
            try
            {
                $arr_salary = explode('_', $s_salary_string);
                $s_salary_min = $arr_salary[0];
                $s_salary_max = $arr_salary[1];
                if($s_salary_min > 0 && $s_salary_max > 0 && $s_salary_max > $s_salary_min)
                {
                    $condition_salary = 'Recruitment.salary_max >= ' . $s_salary_min . ' AND Recruitment.salary_min <= ' . $s_salary_max;
                }
                else
                {
                    if($s_salary_max > 0)
                    {
                        $condition_salary = 'Recruitment.salary_min <= ' . $s_salary_max;
                    }
                    else
                    {
                        if($s_salary_min > 0)
                        {
                            $condition_salary = 'Recruitment.salary_max >= ' . $s_salary_min;
                        }
                    }
                }
            }
            catch (Exception $e)
            {

            }
        }
        //Current date
        $date = getdate();
        $curr_date = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'];
        //Recruitment
        $recruitments = null;
        $this->Recruitment->recursive = -1;
        $order = array(
            'Order.packet_id' => 'DESC',
            'Order.created' => 'DESC',
        );
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
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.id = Order.recruitment_id'
                ),
                array(
                    'table' => 'packets',
                    'alias' => 'Packet',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Order.packet_id = Packet.id'
                ),
            ),
            'fields' => array(
                'Recruitment.id',
                'Recruitment.title',
                'Recruitment.link',
                'Recruitment.salary_min',
                'Recruitment.salary_max',
                'Recruitment.hide_salary',
                'Employer.id',
                'Employer.company_name',
                'Employer.logo',
                'Order.created',
                'Packet.id',
            ),
            'conditions' => array(
                //Dieu kien mac dinh
                'Recruitment.status' => 1,
                'Recruitment.is_paid' => 1,
                'Recruitment.deleted' => 0,
                'Order.status' => 1,
                'Order.deleted' => 0,
                'Order.expiry >=' => $curr_date,
                //Điều kiện tìm kiếm
                $condition_id_recruitment,//Mảng các recruitment_id sau khi lọc job và province
                $condition_key,
                $condition_level,
                $condition_salary,
                $condition_employer
            ),
            'order' => $order,
            'limit' => 10,
            'paramType' => 'querystring'
        );
        try
        {
            $recruitments = $this->paginate('Recruitment');
            //Push recruitment_province vào recruitment
            $i = 0;
            foreach ($recruitments as $item)
            {
                $recruitment_id = $item['Recruitment']['id'];
                $recruitments_provinces = null;
                ClassRegistry::init('RecruitmentProvince')->recursive = -1;
                $recruitments_provinces = ClassRegistry::init('RecruitmentProvince')->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'provinces',
                            'alias' => 'Province',
                            'foreignKey' => false,
                            'conditions' => 'RecruitmentProvince.province_id = Province.id'
                        )
                    ),
                    'fields' => array(
                        'Province.id',
                        'Province.provincename'
                    ),
                    'conditions' => array('RecruitmentProvince.recruitment_id' => $recruitment_id)
                ));
                $recruitments[$i]['RecruitmentProvince'] = $recruitments_provinces;
                $i = $i + 1;
            }
        }
        catch (Exception $exception)
        {

        }
        $Job = new JobsController();
        $jobs = $Job->_get_jobs_option_link();
        $Province = new ProvincesController();
        $provinces = $Province->_get_province_option_link();
        $levels = null;
        $this->Recruitment->Level->recursive = -1;
        $levels = $this->Recruitment->Level->find('all');
        //Cong ty noi bat, select công ty đăng nhiều tin nhất
        $company_features = null;
        $this->Recruitment->Employer->recursive = -1;
        $company_features = $this->Recruitment->Employer->find('all', array(
            'joins' => array(
                array(
                    'table' => 'recruitments',
                    'alias' => 'Recruitment',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Employer.id = Recruitment.employer_id'
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
                'Employer.id',
                'Employer.logo',
                'count(`Recruitment`.`id`) as sum'
            ),
            'limit' => 5,
            'group' => array('Employer.id', 'Employer.logo'),
            'order' => array('sum' => 'DESC')
        ));
        //
        //Việc làm đã lưu lấy mảng các recruitment_id đã lưu
        $arr_recruitments_saved = null;
        if($this->Session->check('S_Member'))
        {
            $member_id = $this->Session->read('S_Member.id');
            $this->Recruitment->MemberRecruitment->recursive = -1;
            $recruitments_saved = $this->Recruitment->MemberRecruitment->find('all', array(
                'fields' => array('recruitment_id'),
                'conditions' => array('member_id' => $member_id),
                'order' => array('recruitment_id' => 'ASC')
            ));
            if($recruitments_saved)
            {
                $i = 0;
                foreach ($recruitments_saved as $item)
                {
                    $arr_recruitments_saved[$i] = $item['MemberRecruitment']['recruitment_id'];
                    $i = $i + 1;
                }
            }
        }
        //Set
        $this->set(array(
            'company_features' => $company_features,
            'recruitments' => $recruitments,
            'jobs' => $jobs,
            'provinces' => $provinces,
            'levels' => $levels,
            'arr_recruitments_saved' => $arr_recruitments_saved,
            //Trả lại điều kiện tìm kiếm trên view
            's_job_link' => $s_job_link . '-j' . $s_job_id,
            's_province_link' => $s_province_link . '-p' . $s_province_id,
            's_key_word' => $s_key,
            'level_id' => $s_level_id,
            's_salary' => $s_salary_string
        ));
    }
    function view()
    {
        $link = isset($this->params['link'])? $this->params['link']: '';
        $id = isset($this->params['id'])? $this->params['id']: '';
        //Current date
        $date = getdate();
        $curr_date = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'];
        $recruitments = null;
        $this->Recruitment->recursive = -1;
        $recruitments = $this->Recruitment->find('first', array(
            'joins' => array(
                array(
                    'table' => 'employers',
                    'alias' => 'Employer',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.employer_id = Employer.id'
                ),
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.level_id = Level.id'
                ),
                array(
                    'table' => 'recruitments_languages',
                    'alias' => 'RecruitmentLanguage',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.recruitment_language_id = RecruitmentLanguage.id'
                ),
                array(
                    'table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.id = Order.recruitment_id'
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
                'Recruitment.*',
                'Level.levelname',
                'Employer.*',
                'RecruitmentLanguage.recruitment_language_name',
                'Order.created',
                'Scale.scale_name'
            ),
            'conditions' => array(
                'Recruitment.id' => $id,
                'Recruitment.link' => $link,
                'Recruitment.status' => 1,
                'Recruitment.is_paid' => 1,
                'Recruitment.deleted' => 0,
                'Order.status' => 1,
                'Order.deleted' => 0,
                'Order.expiry >=' => $curr_date
            )
        ));
        $save_or_applied_recruitments = null;
        if($recruitments)
        {
            //Update view
            $this->Recruitment->query('UPDATE recruitments SET view = view + 1 WHERE id = ' . (int)$id);
            //Lưu danh sách đã xem vào session
            $arr_list_viewed = array();
            if($this->Session->check('S_ListViewed'))
            {
                $arr_list_viewed = $this->Session->read('S_ListViewed');
            }
            if(!in_array($id, $arr_list_viewed))
            {
                array_push($arr_list_viewed, $id);
            }
            $this->Session->write('S_ListViewed', $arr_list_viewed);
            //Kiểm tra tin đang xem có save hay apply hay chưa
            if($this->Session->check('S_Member'))
            {
                $member_id = $this->Session->read('S_Member.id');
                $this->Recruitment->MemberRecruitment->recursive = -1;
                $save_or_applied_recruitments = $this->Recruitment->MemberRecruitment->find('first', array(
                    'conditions' => array(
                        'member_id' => $member_id,
                        'recruitment_id' => $id
                    )
                ));
            }
            //Lấy phúc lợi của công ty
            $benefits = null;
            ClassRegistry::init('EmployerBenefit')->recursive = -1;
            $benefits = ClassRegistry::init('EmployerBenefit')->find('all', array(
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
                    'EmployerBenefit.employer_id' => $recruitments['Employer']['id']
                )
            ));
            //
            //Province
            $recruitments_provinces = null;
            ClassRegistry::init('RecruitmentProvince')->recursive = -1;
            $recruitments_provinces = ClassRegistry::init('RecruitmentProvince')->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'provinces',
                        'alias' => 'Province',
                        'foreignKey' => false,
                        'conditions' => 'RecruitmentProvince.province_id = Province.id'
                    )
                ),
                'fields' => array(
                    'Province.id',
                    'Province.provincename'
                ),
                'conditions' => array('RecruitmentProvince.recruitment_id' => $id)
            ));
            $recruitments['RecruitmentProvince'] = $recruitments_provinces;
            $id_recruitments_province = null;
            $i = 0;
            //Mảng các province_id của tin hiển thị
            foreach ($recruitments_provinces as $rp)
            {
                $id_recruitments_province[$i] = $rp['Province']['id'];
                $i = $i + 1;
            }
            //Jobs
            $recruitments_jobs = null;
            ClassRegistry::init('RecruitmentJob')->recursive = -1;
            $recruitments_jobs = ClassRegistry::init('RecruitmentJob')->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'jobs',
                        'alias' => 'Job',
                        'foreignKey' => false,
                        'conditions' => 'RecruitmentJob.job_id = Job.id'
                    )
                ),
                'fields' => array(
                    'Job.id',
                    'Job.jobname'
                ),
                'conditions' => array('RecruitmentJob.recruitment_id' => $id)
            ));
            $recruitments['RecruitmentJob'] = $recruitments_jobs;
            $id_recruitments_job = null;
            $j = 0;
            //Mảng các job của tin đang hiển thị
            foreach ($recruitments_jobs as $rj)
            {
                $id_recruitments_job[$j] = $rj['Job']['id'];
                $j = $j + 1;
            }
//            debug($recruitments);
//            /////Tin liên quan
            //Lọc lấy id cùng province và cùng job với tin đang hiển thị
            //Do Quan hệ recruitment->province, và recruitment->job là 1 nhiều nên join lại rồi distinct id recruitment
            $id_recruitments_relative = null;
            $this->Recruitment->recursive = -1;
            $id_recruitments_relative = $this->Recruitment->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'recruitments_provinces',
                        'alias' => 'RecruitmentProvince',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'Recruitment.id = RecruitmentProvince.recruitment_id'
                    ),
                    array(
                        'table' => 'recruitments_jobs',
                        'alias' => 'RecruitmentJob',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'Recruitment.id = RecruitmentJob.recruitment_id'
                    )
                ),
                'fields' => array(
                    //Distinct id
                    'DISTINCT Recruitment.id',
                ),
                'conditions' => array(
                    'Recruitment.id !=' => $id,
                    //WHERE IN mảng province
                    'RecruitmentProvince.province_id' => $id_recruitments_province,
                    //WHERE IN mảng job
                    'RecruitmentJob.job_id' => $id_recruitments_job,
                )
            ));
            $k = 0;
            //Mảng các recruitment_id liên
            $id_relative = null;
            foreach ($id_recruitments_relative as $item_id)
            {
                $id_relative[$k] = $item_id['Recruitment']['id'];
            }
            $recruitments_relative = null;
            $this->Recruitment->recursive = -1;
            $recruitments_relative = $this->Recruitment->find('all', array(
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
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'Recruitment.id = Order.recruitment_id'
                    )
                ),
                'fields' => array(
                    'Recruitment.title',
                    'Recruitment.id',
                    'Recruitment.link',
                    'Employer.company_name',
                    'Employer.logo',
                ),
                'conditions' => array(
                    //WHERE IN id_relative của recruitment
                    'Recruitment.id' => $id_relative,
                    'Recruitment.status' => 1,
                    'Recruitment.is_paid' => 1,
                    'Recruitment.deleted' => 0,
                    'Order.status' => 1,
                    'Order.deleted' => 0,
                    'Order.expiry >=' => $curr_date
                ),
                'limit' => 10
            ));
//            debug($recruitments_relative);
            //End tin liên quan
            $this->set(array(
                'benefits' => $benefits,
                'recruitments' => $recruitments,
                'recruitments_relative' => $recruitments_relative,
                'save_or_applied_recruitments' => $save_or_applied_recruitments,
                'title' => $recruitments['Recruitment']['title'],
                'description' => '',
                'key_words' => ''
            ));
        }
        else
        {

        }
    }
    function save()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Member'))
        {
            $member_id = $this->Session->read('S_Member.id');
            $recruitment_id = $this->request->data['recruitmentId'];
            $this->Recruitment->MemberRecruitment->recursive = -1;
            $count = $this->Recruitment->MemberRecruitment->find('count', array(
                'conditions' => array(
                    'member_id' => $member_id,
                    'recruitment_id' => $recruitment_id
                )
            ));
            if($count == 0)
            {
                $this->Recruitment->MemberRecruitment->set('member_id', $member_id);
                $this->Recruitment->MemberRecruitment->set('recruitment_id', $recruitment_id);
                $this->Recruitment->MemberRecruitment->set('recruitment_id', $recruitment_id);
                $this->Recruitment->MemberRecruitment->set('is_applied', 0);
                $this->Recruitment->MemberRecruitment->set('is_view', 0);
                if($this->Recruitment->MemberRecruitment->save())
                {
                    echo json_encode(array('status' => 'success'));
                }
                else
                {
                    echo json_encode(array('status' => 'fail'));
                }
            }
            else
            {
                $this->Recruitment->MemberRecruitment->recursive = -1;
                $count_applied = $this->Recruitment->MemberRecruitment->find('count', array(
                    'conditions' => array(
                        'member_id' => $member_id,
                        'recruitment_id' => $recruitment_id,
                        'is_applied' => 1
                    )
                ));
                if($count_applied > 0)
                {
                    echo json_encode(array('status' => 'applied'));
                }
                else
                {
                    $this->Recruitment->MemberRecruitment->deleteAll(array('member_id' => $member_id, 'recruitment_id' => $recruitment_id, 'is_applied' => 0));
                    echo json_encode(array('status' => 'deleted'));
                }
            }

        }
        else
        {
            echo json_encode(array('status' => 'not_login'));
        }
    }
    function apply_recruitment()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Member'))
        {
            $member_id = $this->Session->read('S_Member.id');
            $recruitment_id = $this->request->data['recruitmentId'];
            $this->Recruitment->MemberRecruitment->recursive = -1;
            $recruitment_applied = $this->Recruitment->MemberRecruitment->find('first', array(
                'conditions' => array(
                    'member_id' => $member_id,
                    'recruitment_id' => $recruitment_id
                )
            ));
            //Kiểm tra trạng thái của recruitment
            //Status = 1; Deleted = 0, Expired > now...
            //Nếu thỏa mãn mới applied



            ///Kiểm tra tồn tại
            if($recruitment_applied)
            {
                //Đã ứng tuyển
                if($recruitment_applied['MemberRecruitment']['is_applied'] == 1)
                {
                    echo json_encode(array('status' => 'applied'));
                }
                //Đã lưu và chưa ứng tuyển
                else
                {
                    //
                    $this->Recruitment->MemberRecruitment->set('id', $recruitment_applied['MemberRecruitment']['id']);
                    $this->Recruitment->MemberRecruitment->set('is_applied', 1);
                    $this->Recruitment->MemberRecruitment->set('date_applied', $this->get_curr_date());
                    if($this->Recruitment->MemberRecruitment->save())
                    {
                        echo json_encode(array('status' => 'success'));
                    }
                    else
                    {
                        echo json_encode(array('status' => 'fail'));
                    }
                }
            }
            else
            {
                ///
                $this->Recruitment->MemberRecruitment->set('member_id', $member_id);
                $this->Recruitment->MemberRecruitment->set('recruitment_id', $recruitment_id);
                $this->Recruitment->MemberRecruitment->set('is_applied', 1);
                $this->Recruitment->MemberRecruitment->set('date_applied', $this->get_curr_date());
                if($this->Recruitment->MemberRecruitment->save())
                {
                    echo json_encode(array('status' => 'success'));
                }
                else
                {
                    echo json_encode(array('status' => 'fail'));
                }

            }
        }
        else
        {
            echo json_encode(array('status' => 'not_login'));
        }
    }


    //Employer
    ////////////////////////
    function add()
    {
        $this->is_login_employer();
        $this->layout = 'employer_default';
        /////////////////////////
        //Set
        //Level
        $levels = null;
        $this->Recruitment->Level->recursive = -1;
        $level = $this->Recruitment->Level->find('all');
        if($level)
        {
            foreach ($level as $item)
            {
                $levels[$item['Level']['id']] = $item['Level']['levelname'];
            }
        }
        //Job
        $Job = new JobsController();
        $jobs = $Job->_get_jobs_option();
        //Province
        $Province = new ProvincesController();
        $provinces = $Province->_get_province_option();
        //Ngôn ngữ hồ sơ
        $RecruitmentLanguage = new RecruitmentsLanguagesController();
        $recruitments_languages = $RecruitmentLanguage->_get_recruitment_language();
        //////////

        //Thông tin công ty
        $employers = null;
        $employer_id = $this->Session->read('S_Employer.id');
        $this->Recruitment->Employer->recursive = -1;
        $employers = $this->Recruitment->Employer->find('first', array(
            'joins' => array(
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
                'Scale.id',
            ),
            'conditions' => array(
                'Employer.is_active_email' => 1,
                'Employer.id' => $employer_id
            )
        ));
        $this->set(array(
            'title' => 'Đăng tuyển việc làm',
            'employers' => $employers,
            'provinces' => $provinces,
            'levels' => $levels,
            'jobs' => $jobs,
            'recruitments_languages' => $recruitments_languages,
        ));
        /////////////////////////
        //Post
        if($this->request->is('post'))
        {
            debug($this->request->data);
            //
            $recruitments_jobs = $this->request->data['Recruitment']['recruitments_jobs'];
            $recruitments_provinces = $this->request->data['Recruitment']['recruitments_provinces'];
            $sum_recruitments_jobs = count($recruitments_jobs);
            $sum_recruitments_provinces = count($recruitments_provinces);
            if($sum_recruitments_jobs == 0)
            {
                $this->Session->setFlash('Vui lòng chọn ngành nghề', 'flashWarning');
                return false;
            }
            if($sum_recruitments_jobs > 3)
            {
                $this->Session->setFlash('Vui lòng chọn không quá 3 ngành nghề', 'flashWarning');
                return false;
            }
            if($sum_recruitments_provinces == 0)
            {
                $this->Session->setFlash('Vui lòng chọn nơi làm việc', 'flashWarning');
                return false;
            }
            if($sum_recruitments_provinces > 3)
            {
                $this->Session->setFlash('Vui lòng chọn không quá 3 nơi làm việc', 'flashWarning');
                return false;
            }
            $this->Recruitment->set('employer_id', $employer_id);
            $this->Recruitment->set('status', 1);
            $this->Recruitment->set('deleted', 0);
            $this->Recruitment->set('is_paid', 1);
            $this->Recruitment->set('link', $this->Library->make_link($this->request->data['Recruitment']['title']));
            if($this->Recruitment->save($this->request->data))
            {
                $recruitment_id = $this->Recruitment->id;
                //Save ngành nghề
                for($i = 0; $i < $sum_recruitments_jobs; $i++)
                {
                    $data_recruitments_jobs = array(
                        'recruitment_id' => $recruitment_id,
                        'job_id' => $recruitments_jobs[$i]
                    );
                    $this->Recruitment->RecruitmentJob->saveAll($data_recruitments_jobs);
                }
                //Save nơi làm việc
                for($j = 0; $j < $sum_recruitments_provinces; $j++)
                {
                    $data_recruitments_provinces = array(
                        'recruitment_id' => $recruitment_id,
                        'province_id' => $recruitments_provinces[$j]
                    );
                    $this->Recruitment->RecruitmentProvince->saveAll($data_recruitments_provinces);
                }
                //Save thông tin công ty
                //Save thông tin công ty
                $this->Recruitment->Employer->set('id', $employer_id);
                $this->Recruitment->Employer->save($this->request->data, true, array('company_name', 'address', 'description'));

                //Cut từ dòng này
                //Thêm hóa đơn, mặc định cho free, sau này chuyển qua controller khác thực hiện việc chọn gói tinh và thanh toán
                $date = getdate();
                $cur_date = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'];
                $cur_time = $date['hours'] . '-' . $date['minutes'] . '-' . $date['seconds'];
                $expiry = date('Y-m-d', strtotime($cur_date. '+ 30 days'));
                $data_order = array(
                    'packet_id' => 1,
                    'recruitment_id' => $recruitment_id,
                    'expiry' => $expiry . ' ' . $cur_time,
                    'status' => 1,
                    'deleted' => 0
                );
                $this->Recruitment->Order->save($data_order);
                $this->redirect($this->_base_url_employer . '/viec-lam');
                //Cut tới dòng này và thay vào redirect về controller packet để sử lý
//                $this->redirect($this->_base_url_employer . '/packets/paid/' . $recruitment_id);
                //////////////////////////////////////////////


            }
        }
    }
    function edit()
    {
        $this->is_login_employer();
        $this->layout = 'employer_default';
        $employer_id = $this->Session->read('S_Employer.id');
        /////////////////////////
        $recruitment_id = isset($this->params['recruitment_id'])? $this->params['recruitment_id']: '';
        $this->Recruitment->recursive = -1;
        $recruitments = $this->Recruitment->find('first', array(
            'joins' => array(
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.level_id = Level.id'
                ),
                array(
                    'table' => 'recruitments_languages',
                    'alias' => 'RecruitmentLanguage',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.recruitment_language_id = RecruitmentLanguage.id'
                ),
            ),
            'fields' => array(
                'Recruitment.id',
                'Recruitment.level_id',
                'Recruitment.recruitment_language_id',
                'Recruitment.title',
                'Recruitment.description',
                'Recruitment.require',
                'Recruitment.salary_min',
                'Recruitment.salary_max',
                'Recruitment.hide_salary',
                'Recruitment.fullname',
                'Recruitment.phone',
                'Recruitment.email',
                'Recruitment.keywords',
            ),
            'conditions' => array(
                'Recruitment.id' => $recruitment_id,
                'Recruitment.employer_id' => $employer_id
            )

        ));
        if($recruitments)
        {
            //Lấy ngành của tin tuyển dụng
            $recruitments_jobs_selected = null;
            $this->Recruitment->RecruitmentJob->recrusive = -1;
            $recruitments_jobs = $this->Recruitment->RecruitmentJob->find('all', array(
                'conditions' => array(
                    'RecruitmentJob.recruitment_id' => $recruitment_id
                ),
                'fields' => array(
                    'RecruitmentJob.job_id'
                )
            ));
            if($recruitments_jobs)
            {
                $i = 0;
                foreach ($recruitments_jobs as $item)
                {
                    $recruitments_jobs_selected[$i] = $item['RecruitmentJob']['job_id'];
                    $i = $i + 1;
                }
            }
            //Lấy nơi làm việc của tin tuyển dụng
            $recruitments_provinces_selected = null;
            $this->Recruitment->RecruitmentProvince->recursive = -1;
            $recruitments_provinces = $this->Recruitment->RecruitmentProvince->find('all', array(
                'conditions' => array(
                    'RecruitmentProvince.recruitment_id' => $recruitment_id
                ),
                'fields' => array(
                    'RecruitmentProvince.province_id'
                )
            ));
            if($recruitments_provinces)
            {
                $j = 0;
                foreach ($recruitments_provinces as $item)
                {
                    $recruitments_provinces_selected[$j] = $item['RecruitmentProvince']['province_id'];
                    $j = $j + 1;
                }
            }
        }
        else
        {
            $this->redirect('/nha-tuyen-dung/viec-lam');
        }
        //Set
        //Level
        $levels = null;
        $this->Recruitment->Level->recursive = -1;
        $level = $this->Recruitment->Level->find('all');
        if($level)
        {
            foreach ($level as $item)
            {
                $levels[$item['Level']['id']] = $item['Level']['levelname'];
            }
        }
        //Job
        $Job = new JobsController();
        $jobs = $Job->_get_jobs_option();
        //Province
        $Province = new ProvincesController();
        $provinces = $Province->_get_province_option();
        //Ngôn ngữ hồ sơ
        $RecruitmentLanguage = new RecruitmentsLanguagesController();
        $recruitments_languages = $RecruitmentLanguage->_get_recruitment_language();
        //////////

        //Thông tin công ty
        $employers = null;
        $employer_id = $this->Session->read('S_Employer.id');
        $this->Recruitment->Employer->recursive = -1;
        $employers = $this->Recruitment->Employer->find('first', array(
            'joins' => array(
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
                'Scale.id',
            ),
            'conditions' => array(
                'Employer.is_active_email' => 1,
                'Employer.id' => $employer_id
            )
        ));
        $this->set(array(
            'recruitments' => $recruitments,
            'recruitments_jobs_selected' => $recruitments_jobs_selected,
            'recruitments_provinces_selected' => $recruitments_provinces_selected,
            'title' => 'Sửa việc làm',
            'employers' => $employers,
            'provinces' => $provinces,
            'levels' => $levels,
            'jobs' => $jobs,
            'recruitments_languages' => $recruitments_languages,
        ));
        /////////////////////////
        //Post
        if($this->request->is('post'))
        {
            //
            $recruitments_jobs = $this->request->data['Recruitment']['recruitments_jobs'];
            $recruitments_provinces = $this->request->data['Recruitment']['recruitments_provinces'];
            $sum_recruitments_jobs = count($recruitments_jobs);
            $sum_recruitments_provinces = count($recruitments_provinces);
            if($sum_recruitments_jobs == 0)
            {
                $this->Session->setFlash('Vui lòng chọn ngành nghề', 'flashWarning');
                return false;
            }
            if($sum_recruitments_jobs > 3)
            {
                $this->Session->setFlash('Vui lòng chọn không quá 3 ngành nghề', 'flashWarning');
                return false;
            }
            if($sum_recruitments_provinces == 0)
            {
                $this->Session->setFlash('Vui lòng chọn nơi làm việc', 'flashWarning');
                return false;
            }
            if($sum_recruitments_provinces > 3)
            {
                $this->Session->setFlash('Vui lòng chọn không quá 3 nơi làm việc', 'flashWarning');
                return false;
            }
            $this->Recruitment->set('id', $recruitment_id);
            $this->Recruitment->set('link', $this->Library->make_link($this->request->data['Recruitment']['title']));

            if($this->Recruitment->save($this->request->data, true, array('title', 'link', 'salary_min', 'salary_max', 'level_id', 'hide_salary', 'description', 'require', 'recruitment_language_id', 'fullname', 'email')))
            {
                $this->Recruitment->RecruitmentJob->deleteAll(array('recruitment_id' => $recruitment_id));
                //Save lại ngành nghề
                for($i = 0; $i < $sum_recruitments_jobs; $i++)
                {
                    $data_recruitments_jobs = array(
                        'recruitment_id' => $recruitment_id,
                        'job_id' => $recruitments_jobs[$i]
                    );
                    $this->Recruitment->RecruitmentJob->saveAll($data_recruitments_jobs);
                }
                //Save nơi làm việc
                $this->Recruitment->RecruitmentProvince->deleteAll(array('recruitment_id' => $recruitment_id));
                for($j = 0; $j < $sum_recruitments_provinces; $j++)
                {
                    $data_recruitments_provinces = array(
                        'recruitment_id' => $recruitment_id,
                        'province_id' => $recruitments_provinces[$j]
                    );
                    $this->Recruitment->RecruitmentProvince->saveAll($data_recruitments_provinces);
                }
                //Save thông tin công ty
                $this->Recruitment->Employer->set('id', $employer_id);
                $this->Recruitment->Employer->save($this->request->data, true, array('company_name', 'address', 'description'));
                $this->redirect('/nha-tuyen-dung/viec-lam');
//                $this->redirect($this->_base_url_employer . '/packets/paid/' . $recruitment_id);

            }
        }

    }



    //Admin
    ////////////////////////
    function admin_index()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $url = $this->params['url'];
        $status = isset($url['status'])? $url['status']: '';
        $date = getdate();
        $cur_date = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'];
        $cur_time = $date['hours'] . '-' . $date['minutes'] . '-' . $date['seconds'];
        //Dieu kien
        $conditions = array();
        if($status == 'draft')
        {
            $conditions = array(
                'Recruitment.status' => 1,
                'Recruitment.is_paid' => 0,
                'Recruitment.deleted' => 0
            );
        }
        if($status == 'visible')
        {
            $conditions = array(
                'Recruitment.status' => 1,
                'Recruitment.is_paid' => 1,
                'Order.deleted' => 0,
                'Order.status' => 1,
                'Order.expiry >= ' => $cur_date,
                'Recruitment.deleted' => 0
            );
        }
        if($status == 'expired')
        {
            $conditions = array(
                'Recruitment.status' => 1,
                'Recruitment.is_paid' => 1,
                'Order.deleted' => 0,
                'Order.status' => 1,
                'Order.expiry < ' => $cur_date,
                'Recruitment.deleted' => 0
            );
        }
        if($status == 'hidden')
        {
            $conditions = array(
                'Recruitment.status' => 0,
                'Recruitment.is_paid' => 1,
                'Order.deleted' => 0,
                'Order.status' => 1,
                'Order.expiry >= ' => $cur_date,
                'Recruitment.deleted' => 0
            );
        }
        if($status == 'deleted')
        {
            $conditions = array(
                'Recruitment.status' => 0,
                'Recruitment.is_paid' => 1,
                'Order.deleted' => 1,
                'Order.status' => 1,
                'Recruitment.deleted' => 1
            );
        }
        $jobs = null;
        $this->Recruitment->recursive = -1;
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
                'Employer.id',
                'Employer.company_name',
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
        if($this->Session->check('Admin'))
        {
            $arr_id_recruitment = array();
            if(isset($this->request->data['arr_recruitment']))
            {
                $arr_id_recruitment = $this->request->data['arr_recruitment'];
            }
            $this->Recruitment->recursive = -1;
            $recruitments = $this->Recruitment->find('all', array(
                'fields' => array('id'),
                'conditions' => array('id' => $arr_id_recruitment)
            ));
            if($recruitments)
            {
                $i = 0;
                foreach ($recruitments as $item)
                {
                    $this->Recruitment->recursive = -1;
                    $count_applied = $this->Recruitment->MemberRecruitment->find('count', array(
                        'conditions' => array(
                            'MemberRecruitment.is_applied' => 1,
                            'MemberRecruitment.recruitment_id' => $item['Recruitment']['id']
                        ),
                    ));
                    $data[$i] = array(
                        'recruitment' => $item['Recruitment']['id'],
                        'sum' => $count_applied,
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
    function admin_edit($recruitment_id = '')
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        /////////////////////////
        $this->Recruitment->recursive = -1;
        $recruitments = $this->Recruitment->find('first', array(
            'joins' => array(
                array(
                    'table' => 'levels',
                    'alias' => 'Level',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.level_id = Level.id'
                ),
                array(
                    'table' => 'recruitments_languages',
                    'alias' => 'RecruitmentLanguage',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.recruitment_language_id = RecruitmentLanguage.id'
                ),
            ),
            'fields' => array(
                'Recruitment.id',
                'Recruitment.level_id',
                'Recruitment.recruitment_language_id',
                'Recruitment.title',
                'Recruitment.description',
                'Recruitment.require',
                'Recruitment.salary_min',
                'Recruitment.salary_max',
                'Recruitment.hide_salary',
                'Recruitment.fullname',
                'Recruitment.phone',
                'Recruitment.email',
                'Recruitment.keywords',
            ),
            'conditions' => array(
                'Recruitment.id' => $recruitment_id,
            )

        ));
        if($recruitments)
        {
            //Lấy ngành của tin tuyển dụng
            $recruitments_jobs_selected = null;
            $this->Recruitment->RecruitmentJob->recrusive = -1;
            $recruitments_jobs = $this->Recruitment->RecruitmentJob->find('all', array(
                'conditions' => array(
                    'RecruitmentJob.recruitment_id' => $recruitment_id
                ),
                'fields' => array(
                    'RecruitmentJob.job_id'
                )
            ));
            if($recruitments_jobs)
            {
                $i = 0;
                foreach ($recruitments_jobs as $item)
                {
                    $recruitments_jobs_selected[$i] = $item['RecruitmentJob']['job_id'];
                    $i = $i + 1;
                }
            }
            //Lấy nơi làm việc của tin tuyển dụng
            $recruitments_provinces_selected = null;
            $this->Recruitment->RecruitmentProvince->recursive = -1;
            $recruitments_provinces = $this->Recruitment->RecruitmentProvince->find('all', array(
                'conditions' => array(
                    'RecruitmentProvince.recruitment_id' => $recruitment_id
                ),
                'fields' => array(
                    'RecruitmentProvince.province_id'
                )
            ));
            if($recruitments_provinces)
            {
                $j = 0;
                foreach ($recruitments_provinces as $item)
                {
                    $recruitments_provinces_selected[$j] = $item['RecruitmentProvince']['province_id'];
                    $j = $j + 1;
                }
            }
        }
        else
        {
            $this->redirect('/nha-tuyen-dung/viec-lam');
        }
        //Set
        //Level
        $levels = null;
        $this->Recruitment->Level->recursive = -1;
        $level = $this->Recruitment->Level->find('all');
        if($level)
        {
            foreach ($level as $item)
            {
                $levels[$item['Level']['id']] = $item['Level']['levelname'];
            }
        }
        //Job
        $Job = new JobsController();
        $jobs = $Job->_get_jobs_option();
        //Province
        $Province = new ProvincesController();
        $provinces = $Province->_get_province_option();
        //Ngôn ngữ hồ sơ
        $RecruitmentLanguage = new RecruitmentsLanguagesController();
        $recruitments_languages = $RecruitmentLanguage->_get_recruitment_language();
        //////////

        //Thông tin công ty
        $employers = null;
        $employer_id = $this->Session->read('S_Employer.id');
        $this->Recruitment->Employer->recursive = -1;
        $employers = $this->Recruitment->Employer->find('first', array(
            'joins' => array(
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
                'Scale.id',
            ),
            'conditions' => array(
                'Employer.is_active_email' => 1,
                'Employer.id' => $employer_id
            )
        ));
        $this->set(array(
            'recruitments' => $recruitments,
            'recruitments_jobs_selected' => $recruitments_jobs_selected,
            'recruitments_provinces_selected' => $recruitments_provinces_selected,
            'title' => 'Sửa việc làm',
            'employers' => $employers,
            'provinces' => $provinces,
            'levels' => $levels,
            'jobs' => $jobs,
            'recruitments_languages' => $recruitments_languages,
        ));
        /////////////////////////
        //Post
        if($this->request->is('post'))
        {
            //
            $recruitments_jobs = $this->request->data['Recruitment']['recruitments_jobs'];
            $recruitments_provinces = $this->request->data['Recruitment']['recruitments_provinces'];
            $sum_recruitments_jobs = count($recruitments_jobs);
            $sum_recruitments_provinces = count($recruitments_provinces);
            if($sum_recruitments_jobs == 0)
            {
                $this->Session->setFlash('Vui lòng chọn ngành nghề', 'flashWarning');
                return false;
            }
            if($sum_recruitments_jobs > 3)
            {
                $this->Session->setFlash('Vui lòng chọn không quá 3 ngành nghề', 'flashWarning');
                return false;
            }
            if($sum_recruitments_provinces == 0)
            {
                $this->Session->setFlash('Vui lòng chọn nơi làm việc', 'flashWarning');
                return false;
            }
            if($sum_recruitments_provinces > 3)
            {
                $this->Session->setFlash('Vui lòng chọn không quá 3 nơi làm việc', 'flashWarning');
                return false;
            }
            $this->Recruitment->set('id', $recruitment_id);
            $this->Recruitment->set('link', $this->Library->make_link($this->request->data['Recruitment']['title']));

            if($this->Recruitment->save($this->request->data, true, array('title', 'link', 'salary_min', 'salary_max', 'level_id', 'hide_salary', 'description', 'require', 'recruitment_language_id', 'fullname', 'email')))
            {
                $this->Recruitment->RecruitmentJob->deleteAll(array('recruitment_id' => $recruitment_id));
                //Save lại ngành nghề
                for($i = 0; $i < $sum_recruitments_jobs; $i++)
                {
                    $data_recruitments_jobs = array(
                        'recruitment_id' => $recruitment_id,
                        'job_id' => $recruitments_jobs[$i]
                    );
                    $this->Recruitment->RecruitmentJob->saveAll($data_recruitments_jobs);
                }
                //Save nơi làm việc
                $this->Recruitment->RecruitmentProvince->deleteAll(array('recruitment_id' => $recruitment_id));
                for($j = 0; $j < $sum_recruitments_provinces; $j++)
                {
                    $data_recruitments_provinces = array(
                        'recruitment_id' => $recruitment_id,
                        'province_id' => $recruitments_provinces[$j]
                    );
                    $this->Recruitment->RecruitmentProvince->saveAll($data_recruitments_provinces);
                }
                //Save thông tin công ty
                $this->Recruitment->Employer->set('id', $employer_id);
                $this->Recruitment->Employer->save($this->request->data, true, array('company_name', 'address', 'description'));
                $this->redirect('/admin/recruitments');
//                $this->redirect($this->_base_url_employer . '/packets/paid/' . $recruitment_id);

            }
        }

    }

}