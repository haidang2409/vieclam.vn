<?php
class RecruitmentStatus extends AppModel
{
    public $useTable = 'recruitments_status';
    public $hasMany = array(
        'MemberRecruitment' => array(
            'className' => 'MemberRecruitment',
            'foreignKey' => 'recruitment_status_id'
        )
    );
}