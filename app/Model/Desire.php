<?php
//Công việc mong muốn
class Desire extends AppModel
{
    public $useTable = 'desires';
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id'
        ),
        'Level' => array(
            'className' => 'Level',
            'foreignKey' => 'level_id'
        )
    );
    public $hasMany = array(
        'DesireJob' => array(
            'className' => 'DesireJob',
            'foreignKey' => 'desire_id'
        ),
        'DesireProvince' => array(
            'className' => 'DesireProvince',
            'foreignKey' => 'desire_id'
        ),
        'DesireBenefit' => array(
            'className' => 'DesireBenefit',
            'foreignKey' => 'desire_id'
        )
    );

    //Validate
    public $validate = array(
        'salary' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập mức lương mong muốn'
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Vui lòng nhập đúng mức lương mong muốn'
            )
        )
    );


    //Function


}