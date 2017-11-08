<?php
class RecruitmentLanguage extends AppModel
{
    public $useTable = 'recruitments_languages';
    public $hasMany = array(
        'Recruitment' => array(
            'className' => 'Recruitment',
            'foreignKey' => 'recruitment_language_id'
        )
    );
}