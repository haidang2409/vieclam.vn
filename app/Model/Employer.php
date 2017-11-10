<?php
class Employer extends AppModel
{
    public $belongsTo = array(
        'Scale' => array(
            'className' => 'Scale',
            'foreignKey' => 'scale_id'
        ),
        'Province' => array(
            'className' => 'Province',
            'foreignKey' => 'province_id'
        )
    );
    public $hasMany = array(
        'Recruitment' => array(
            'className' => 'Recruitment',
            'foreignKey' => 'employer_id'
        ),
        'Image' => array(
            'className' => 'Image',
            'foreignKey' => 'employer_id'
        ),
        'MemberEmployer' => array(
            'className' => 'MemberEmployer',
            'foreignKey' => 'employer_id'
        ),
        'EmployerBenefit' => array(
            'className' => 'EmployerBenefit',
            'foreignKey' => 'employer_id'
        ),
        'EmployerJob' => array(
            'className' => 'EmployerJob',
            'foreignKey' => 'employer_id'
        ),
        'Folder' => array(
            'className' => 'Folder',
            'foreignKey' => 'employer_id'
        )
    );
    public $hasOne = array(

    );
    //Validate
    public $validate = array(
        'scale_id' => array(

        ),
        'email' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập địa chỉ email'
            ),
            'email' => array(
                'rule' => array('email', true),
                'message' => 'Vui lòng nhập đúng email'
            ),
            'isUnique' => array(
                'rule'    => array('isUnique'),
                'message' => 'Địa chỉ email đã tồn tại',
                'on' => 'create'
            ),
        ),
        'password' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Mật khẩu không được để trống',
//                'on' => 'create'
            ),
            'between' => array(
                'rule' => array('between', 8, 32),
                'message' => 'Mật khẩu phải từ %d đến %d ký tự',
//                'on' => 'create'
            ),
        ),
        'repassword' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Xác nhận lại mật khẩu',
                'on' => 'create'
            ),
            'equaltofield' => array(
                'rule' => array('equaltofield','password'),
                'message' => 'Mật khẩu không khớp nhau',
                'on' => 'create'
            )
        ),
        'password_old' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Nhập mật khẩu cũ',
                'on' => 'update'
            ),
            'incorrect' => array(
                'rule' => array('checkpassword'),
                'message' => 'Mật khẩu cũ không đúng',
                'on' => 'update'
            ),
        ),
        'password_new' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Mật khẩu không được để trống',
                'on' => 'create'
            ),
            'between' => array(
                'rule' => array('between', 8, 32),
                'message' => 'Mật khẩu phải từ %d đến %d ký tự',
                'on' => 'update'
            ),
        ),
        're_password_new' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Xác nhận lại mật khẩu',
                'on' => 'update'
            ),
            'equaltofield' => array(
                'rule' => array('equaltofield','password_new'),
                'message' => 'Mật khẩu không khớp nhau',
                'on' => 'update'
            )
        ),
        'company_name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập tên công ty'
            ),
            'between' => array(
                'rule' => array('between', 10, 200),
                'message' => 'Tên công ty từ %d đến %d ký tự'
            )
        ),
        'province_id' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Chọn tỉnh thành'
            )
        ),
        'phone' => array(
//            'notBlank' => array(
//                'rule' => 'notBlank',
//                'message' => 'Nhập số điện thoại'
//            ),
//            'numeric' => array(
//                'rule' => 'numeric',
//                'message' => 'Nhập đúng số điện thoại'
//            ),
//            'between' => array(
//                'rule' => array('between', 10, 11),
//                'message' => 'Nhập đúng số điện thoại'
//            )
        ),
        //Update
        'address' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập địa chỉ công ty',
                'on' => 'update'
            ),
            'between' => array(
                'rule' => array('between', 10, 200),
                'message' => 'Địa chỉ từ %d đến %d ký tự',
                'on' => 'update'
            )
        ),
        'fullname' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập họ tên người liên hệ',
                'on' => 'update'
            ),
            'between' => array(
                'rule' => array('between', 1, 50),
                'message' => 'Họ tên từ %d đến %d ký tự',
                'on' => 'update'
            )
        ),
        'description' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Giới thiệu sơ lược về công ty',
                'on' => 'update'
            ),
            'between' => array(
                'rule' => array('between', 50, 5000),
                'message' => 'Nội dung từ %d đến %d ký tự',
                'on' => 'update'
            )
        ),

    );
    //Function
    public function equaltofield($check, $otherfield)
    {
        $fname = '';
        foreach ($check as $key => $value)
        {
            $fname = $key;
            break;
        }
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname];
    }
    public function beforeSave($options = array()) {
        // hash our password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return parent::beforeSave($options);
    }
}