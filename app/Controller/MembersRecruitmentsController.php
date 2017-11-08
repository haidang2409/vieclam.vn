<?php
class MembersRecruitmentsController extends AppController
{
    public $name = 'MemberRecruitment';
    public $components = array('Mailtemplate', 'Library');

    //User
    ////////////////////////////////
    function delete_saved_ajax()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Member'))
        {
            if($this->request->is('post'))
            {
                $member_id = $this->Session->read('S_Member.id');
                $id = $this->request->data['id'];
                $this->MemberRecruitment->recursive = -1;
                $members_recruitments = $this->MemberRecruitment->find('first', array(
                    'conditions' => array(
                        'id' => $id,
                        'member_id' => $member_id
                    )
                ));
                if($members_recruitments)
                {
                    if($members_recruitments['MemberRecruitment']['is_applied'] == 1)
                    {
                        echo json_encode(array('status' => 'applied', 'message' => 'Tin đã ứng tuyển'));
                    }
                    else
                    {
                        $this->MemberRecruitment->delete($id);
                        echo json_encode(array('status' => 'success', 'message' => 'Đã xóa'));
                    }
                }
                else
                {
                    echo json_encode(array('status' => 'fail', 'message' => 'Lỗi'));
                }
            }
        }
        else
        {
            echo json_encode(array('status' => 'not_login', 'message' => 'Vui lòng đăng nhập'));
        }
    }
    //Employer
    ////////////////////////////////
    function update_status()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Employer'))
        {
            $employer_id = $this->Session->read('S_Employer.id');
            $memberRecruitmentId = $this->request->data['memberRecruitmentId'];
            $recruitmentStatusId = $this->request->data['recruitmentStatusId'];
            $this->MemberRecruitment->recursive = -1;
            $member_recruitments = $this->MemberRecruitment->find('first', array(
                'joins' => array(
                    array(
                        'table' => 'recruitments',
                        'alias' => 'Recruitment',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberRecruitment.recruitment_id = Recruitment.id'
                    ),
                ),
                'conditions' => array(
                    'MemberRecruitment.id' => $memberRecruitmentId,
                    'Recruitment.employer_id' => $employer_id
                )
            ));
            if($member_recruitments)
            {
                $this->MemberRecruitment->set('id', $memberRecruitmentId);
                $this->MemberRecruitment->set('recruitment_status_id', $recruitmentStatusId);
                if($this->MemberRecruitment->save())
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
                echo json_encode(array('status' => 'fail'));
            }
        }
        else
        {
            echo json_encode(array('status' => 'not_login'));
        }
    }

    ////////////////////////////////
    //Admin
    function admin_index()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $url = $this->params['url'];
        $s_recruitment_id = isset($url['recruitmentId'])? $url['recruitmentId']: '';
        $s_recruitmentStatus = isset($url['recruitmentStatus'])? $url['recruitmentStatus']: '';
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
        //Danh sách ứng viên
        $candidates = null;
        $this->MemberRecruitment->recursive = -1;
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
                ),
                array(
                    'table' => 'employers',
                    'alias' => 'Employer',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.employer_id = Employer.id'
                )
            ),
            'fields' => array(
                'Recruitment.title',
                'Recruitment.id',
                'MemberRecruitment.id',
                'MemberRecruitment.date_applied',
                'Member.id',
                'Member.fullname',
                'Employer.id',
                'Employer.company_name'
            ),
            'conditions' => array(
                $condition_recruitment_id,
                'MemberRecruitment.is_applied' => 1
            ),
            'order' => array('MemberRecruitment.date_applied' => 'DESC'),
            'limit' => 10,
            'paramType' => 'querystring'
        );
        try
        {
            $candidates = $this->paginate('MemberRecruitment');
        }
        catch (Exception $exception)
        {

        }
        //
        //Danh sách nhà tuyển dụng lên option tìm kiếm
        $employers_option = null;
        ClassRegistry::init('Employer')->recursive = -1;
        $employers = ClassRegistry::init('Employer')->find('all');
        if($employers)
        {
            foreach ($employers as $item)
            {
                $employers_option[$item['Employer']['id']] = $item['Employer']['company_name'];
            }
        }
        //Danh sách tin tuyển dụng lên option tìm kiếm
        $recruitments_option = null;
        $this->MemberRecruitment->Recruitment->recursive = -1;
        $recruitments = $this->MemberRecruitment->Recruitment->find('all', array(
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
        //Set
        $this->set(array(
            'candidates' => $candidates,
            'recruitments_option' => $recruitments_option,
            'employers_option' => $employers_option,
            'title' => 'Hồ sơ dự tuyển',
            //Trả lại điều kiện tìm kiếm
            'recruitmentId' => $s_recruitment_id
        ));
    }


}