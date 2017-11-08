<?php
class MemberDegree extends AppModel
{
    public $useTable = 'members_degrees';
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id'
        ),
        'Degree' => array(
            'className' => 'Degree',
            'foreignKey' => 'degree_id'
        )
    );

    //Validate
    public $validate = array(
        'specialized' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập chuyên ngành đã học'
            ),
            'between' => array(
                'rule' => array('between', 1, 200),
                'message' => 'Chuyên ngành từ %d đến %d ký tự'
            )
        ),
        'school' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập tên trường đã học'
            ),
            'between' => array(
                'rule' => array('between', 1, 200),
                'message' => 'Tên trường từ %d đến %d ký tự'
            )

        )
    );
}