<?php
class Image extends AppModel
{
    public $belongsTo = array(
        'Employer' => array(
            'className' => 'Employer',
            'foreignKey' => 'employer_id'
        )
    );
}