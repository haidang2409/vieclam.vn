<?php
class Folder extends AppModel
{
    public $belongsTo = array(
        'Employer' => array(
            'className' => 'Employer',
            'foreignKey' => 'employer_id'
        )
    );
    public $hasMany = array(
        'MemberEmployer' => array(
            'className' => 'MemberEmployer',
            'foreignKey' => 'folder_id'
        )
    );
    //Validate
    public $validate = array(
        'folder_name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Tên thư mục không được trống'
            )
        ),
        'color' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Vui lòng chọn màu cho thư mục'
            )
        ),
    );
}