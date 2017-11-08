<?php
class Language extends AppModel
{
    public $hasMany = array(
        'MemberLanguage' => array(
            'className' => 'MemberLanguage',
            'foreignKey' => 'language_id'
        )
    );

    //Validate
    public $validate = array(
        'language_name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập ngôn ngữ'
            ),
            'between' => array(
                'rule' => array('between', 1, 50),
                'message' => 'Ngôn ngữ từ %d đến %d ký tự'
            )
        )
    );
}