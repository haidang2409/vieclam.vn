<?php
class RecruitmentProvince extends AppModel
{
    public $useTable = 'recruitments_provinces';
    public $belongsTo = array(
        'Recruitment' => array(
            'className' => 'Recruitment',
            'foreignKey' => 'recruitment_id'
        ),
        'Province' => array(
            'className' => 'Province',
            'foreignKey' => 'province_id'
        )
    );
}