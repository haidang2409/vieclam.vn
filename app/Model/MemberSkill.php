<?php
class MemberSkill extends AppModel
{
    public $useTable = 'members_skills';
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id'
        ),
        'Skill' => array(
            'className' => 'Skill',
            'foreignKey' => 'skill_id'
        )
    );
}