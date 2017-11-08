<?php
class Province extends AppModel
{
    public $hasMany = array(
        'RecruitmentProvince' => array(
            'className' => 'RecruitmentProvince',
            'foreignKey' => 'province_id'
        ),
        'Employer' => array(
            'className' => 'Employer',
            'foreignKey' => 'province_id'
        ),
        'DesireProvince' => array(
            'className' => 'DesireProvince',
            'foreignKey' => 'province_id'
        ),
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'province_id'
        )
    );
    public $belongsTo = array(
        'Zone' => array(
            'className' => 'Zone',
            'foreignKey' => 'zone_id'
        )
    );
    //Validate
    public $validate = array(
        'provincename' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Tên tỉnh thành không để trống'
            )
        ),
        'zone_id' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Chọn vùng'
            )
        )
    );
}