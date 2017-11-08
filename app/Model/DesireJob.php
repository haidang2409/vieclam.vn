<?php
class DesireJob extends AppModel
{
    public $useTable = 'desires_jobs';
    public $belongsTo = array(
        'Desire' => array(
            'className' => 'Desire',
            'foreignKey' => 'desire_id'
        ),
        'Job' => array(
            'className' => 'Job',
            'foreignKey' => 'job_id'
        )
    );
}