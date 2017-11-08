<?php
class RecruitmentJob extends AppModel
{
    public $useTable = 'recruitments_jobs';
    public $belongsTo = array(
        'Recruitment' => array(
            'className' => 'Recruitment',
            'foreignKey' => 'recruitment_id'
        ),
        'Job' => array(
            'className' => 'Job',
            'foreignKey' => 'job_id'
        )
    );
}