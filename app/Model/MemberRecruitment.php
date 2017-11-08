<?php
class MemberRecruitment extends AppModel
{
    public $useTable = 'members_recruitments';
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id'
        ),
        'Recruitment' => array(
            'className' => 'Recruitment',
            'foreignKey' => 'recruitment_id'
        ),
        'RecruitmentStatus' => array(
            'className' => 'RecruitmentStatus',
            'foreignKey' => 'recruitment_status_id'
        )
    );
}