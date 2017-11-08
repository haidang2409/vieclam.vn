<?php
class MemberLanguage extends AppModel
{
    public $useTable = 'members_languages';
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id'
        ),
        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id'
        ),
        'LanguageLevel' => array(
            'className' => 'LanguageLevel',
            'foreignKey' => 'language_level_id'
        )
    );
}