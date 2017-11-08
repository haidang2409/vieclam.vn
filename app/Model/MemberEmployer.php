<?php
class MemberEmployer extends AppModel
{
    public $useTable = 'members_employers';
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id'
        ),
        'Employer' => array(
            'className' => 'Employer',
            'foreignKey' => 'employer_id'
        ),
        'Folder' => array(
            'className' => 'Folder',
            'foreignKey' => 'folder_id'
        )
    );
}