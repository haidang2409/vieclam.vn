<?php
class Degree extends AppModel
{
    public $hasMany = array(
        'MemberDegree' => array(
            'className' => 'MemberDegree',
            'foreignKey' => 'degree_id'
        )
    );

    //Validate
    public $validate = array(
        'degree_name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập trình độ'
            ),
            'between' => array(
                'rule' => array('between', 1, 50),
                'message' => 'Trình độ từ %d đến %d ký tự'
            )
        )
    );
}