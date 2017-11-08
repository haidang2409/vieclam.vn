<?php
//Quy mô công ty
class Scale extends AppModel
{
    public $hasMany = array(
        'Employer' => array(
            'className' => 'Employer',
            'foreignKey' => 'scale_id'
        ),
    );

    //Validate
    public $validate = array(
        'scale_name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập quy mô công ty'
            ),
            'between' => array(
                'rule' => array('between', 1, 200),
                'message' => 'Quy mô công ty từ %d đến %d ký tự'
            )
        )
    );

}