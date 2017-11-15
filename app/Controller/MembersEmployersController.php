<?php
class MembersEmployersController extends AppController
{
    public $name = 'MemberEmployer';



    //Employer
    //Lưu hồ sơ ứng viên
    function save_resume_ajax()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Employer'))
        {
            $employer_id = $this->Session->read('S_Employer.id');
            $member_id = $this->request->data['member_id'];
            $this->MemberEmployer->recursive = -1;
            $count = $this->MemberEmployer->find('count', array(
                'conditions' => array(
                    'MemberEmployer.member_id' => $member_id,
                    'MemberEmployer.employer_id' => $employer_id
                )
            ));
            $now = $this->get_curr_date();
            //Đã có do insert trước số lần xem hồ sơ của ứng viên nhưng chưa save hồ sơ
            if($count > 0)
            {
                if($this->MemberEmployer->updateAll(array('is_saved' => 1, 'date_saved' => "'$now'", 'is_viewed_member' => 0), array('MemberEmployer.member_id' => $member_id, 'MemberEmployer.employer_id' => $employer_id)))
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
                $data = array(
                    'member_id' => $member_id,
                    'employer_id' => $employer_id,
                    'view' => 1,
                    'is_saved' => 1,
                    'date_saved' => "'$now'"
                );
                if($this->MemberEmployer->save($data))
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
    //Đưa hồ sơ vào thư mục
    function update_folder_ajax()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Employer'))
        {
            $employer_id = $this->Session->read('S_Employer.id');
            if($this->request->is('post'))
            {
                $folder_id = $this->request->data['folder_id'];
                $arr_resume = $this->request->data['resume'];
                $count_resume_update = count($arr_resume);
                for($i = 0; $i < $count_resume_update; $i++)
                {
                    $data_update = array(
                        'folder_id' => $folder_id,
                    );
                    $data_where = array(
                        'MemberEmployer.id' => $arr_resume[$i],
                        'MemberEmployer.employer_id' => $employer_id
                    );
                    $this->MemberEmployer->updateAll($data_update, $data_where);
                }
                echo json_encode(array('status' => 'success'));
            }
        }
        else
        {
            echo json_encode(array('status' => 'not_login'));
        }
    }
    //
    function delete_resume_ajax()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Employer'))
        {
            $employer_id = $this->Session->read('S_Employer.id');
            $resume_id = $this->request->data['resume_id'];
            if($this->MemberEmployer->updateAll(array('MemberEmployer.is_saved' => 0, 'MemberEmployer.folder_id' => null), array('MemberEmployer.id' => $resume_id, 'MemberEmployer.employer_id' => $employer_id)))
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
            echo json_encode(array('status' => 'not_login'));
        }
    }
    //
    function resume_saved_ajax()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Employer'))
        {
            if($this->request->is('post'))
            {
                $employer_id = $this->Session->read('S_Employer.id');
                $arr_member_id = $this->request->data['member_id'];
                $this->MemberEmployer->recursive = -1;
                $members = $this->MemberEmployer->find('all', array(
                    'fields' => array(
                        'MemberEmployer.member_id',
                        'MemberEmployer.is_saved'
                    ),
                    'conditions' => array(
                        'MemberEmployer.employer_id' => $employer_id,
                        'MemberEmployer.member_id' => $arr_member_id
                    )
                ));
                if($members)
                {
                    $data = array();
                    $i = 0;
                    foreach ($members as $item)
                    {
                        $data[$i] = array(
                            'member_id' => $item['MemberEmployer']['member_id'],
                            'is_saved' => $item['MemberEmployer']['is_saved']
                        );
                        $i = $i + 1;
                    }
                    echo json_encode($data);
                }
                else
                {
                    echo json_encode(null);
                }
            }
        }
        else
        {
            echo json_encode(null);
        }
    }

    //Admin
}