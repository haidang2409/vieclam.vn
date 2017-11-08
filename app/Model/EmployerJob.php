<?php
class EmployerJob extends AppModel
{
    public $useTable = 'employers_jobs';
    public $belongsTo = array(
        'Employer' => array(
            'className' => 'Employer',
            'foreignKey' => 'employer_id'
        ),
        'Job' => array(
            'className' => 'Job',
            'foreignKey' => 'job_id'
        )
    );
}