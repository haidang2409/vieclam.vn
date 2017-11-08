<?php
class Job extends AppModel
{
    public $hasMany = array(
        'RecruitmentJob' => array(
            'className' => 'RecruitmentJob',
            'foreignKey' => 'job_id'
        ),
        'DesireJob' => array(
            'className' => 'DesireJob',
            'foreignKey' => 'job_id'
        ),
        'EmployerJob' => array(
            'className' => 'EmployerJob',
            'foreignKey' => 'job_id'
        )
    );

    //Validate
    public $validate = array(
        'jobname' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập ngành nghề'
            ),
            'between' => array(
                'rule' => array('between', 1, 200),
                'message' => 'Ngành nghề từ %d đến %d ký tự'
            )
        )
    );
}