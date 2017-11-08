<?php
class Work extends AppModel
{
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id'
        )
    );

    //Validate
    public $validate = array(
        'title' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập chức danh'
            ),
            'between' => array(
                'rule' => array('between', 1, 200),
                'message' => 'Chức danh từ %d đến %d ký tự'
            )
        ),
        'company_name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập tên công ty',
            ),
            'between' => array(
                'rule' => array('between', 1, 200),
                'message' => 'Tên công ty từ %d đến %d ký tự'
            )
        )
    );
}