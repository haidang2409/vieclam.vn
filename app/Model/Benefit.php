<?php
//Trình độ, bằng cấp
class Benefit extends AppModel
{
    public $hasMany = array(
        'EmployerBenefit' => array(
            'className' => 'EmployerBenefit',
            'foreignKey' => 'benefit_id'
        ),
        'DesireBenefit' => array(
            'className' => 'DesireBenefit',
            'foreignKey' => 'benefit_id'
        )
    );
    //Validate
    public $validate = array(
        'benefit_name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập phúc lợi'
            ),
            'between' => array(
                'rule' => array('between', 5, 200),
                'message' => 'Phúc lợi từ %d đến %d ký tự'
            )
        )
    );
}