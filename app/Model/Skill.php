<?php
class Skill extends AppModel
{
    public $hasMany = array(
        'MemberSkill' => array(
            'className' => 'MemberSkill',
            'foreignKey' => 'skill_id'
        )
    );

    //Validate
    public $validate = array(
        'skill_name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập kỹ năng'
            ),
            'between' => array(
                'rule' => array('between', 1, 200),
                'message' => 'Kỹ năng từ %d đến %d ký tự'
            )
        )
    );
}