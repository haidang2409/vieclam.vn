<?php
class LanguageLevel extends AppModel
{
    public $useTable = 'languages_levels';
    public $hasMany = array(
        'MemberLanguage' => array(
            'className' => 'MemberLanguage',
            'foreignKey' => 'language_level_id'
        )
    );

    //Validate
    public $validate = array(
        'level_name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập trình độ ngôn ngữ'
            ),
            'between' => array(
                'rule' => array('between', 1, 50),
                'message' => 'Trình độ ngôn ngữ từ %d đến %d ký tự'
            )
        )
    );
}