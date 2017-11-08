<?php
class Refer extends AppModel
{
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id'
        )
    );

    //Validate
    public $validate = array(
        'fullname' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập họ tên'
            ),
            'between' => array(
                'rule' => array('between', 1, 50),
                'message' => 'Họ tên từ %d đến $d ký tự'
            )
        ),
        'title' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập chức danh'
            ),
            'between' => array(
                'rule' => array('between', 1, 50),
                'message' => 'Chức danh từ %d đến %d ký tự'
            )
        ),
        'company' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập tên công ty'
            ),
            'between' => array(
                'rule' => array('between', 1, 200),
                'message' => 'Tên công ty từ %d đến %d ký tự'
            )
        ),
//        'email' => array(
//            'email' => array(
//                'rule' => array('email', true),
//                'message' => 'Nhập đúng email'
//            ),
//            'between' => array(
//                'rule' => array('between', 1, 50),
//                'message' => 'Email từ %d đến %d ký tự'
//            )
//        )
    );

}