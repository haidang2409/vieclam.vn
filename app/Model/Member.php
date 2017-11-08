<?php
/**
 * Created by PhpStorm.
 * User: nhdang
 * Date: 6/16/2017
 * Time: 3:54 PM
 */
App::uses('AuthComponent', 'Controller/Component');
class Member extends AppModel
{
    public $belongsTo = array(
        'Province' => array(
            'className' => 'Province',
            'foreignKey' => 'province_id',
        ),
        'Level' => array(
            'className' => 'Level',
            'foreignKey' => 'level_id'
        )
    );
    public $hasMany = array(
        'Work' => array(
            'className' => 'Work',
            'foreignKey' => 'member_id'
        ),
        'MemberDegree' => array(
            'className' => 'MemberDegree',
            'foreignKey' => 'member_id'
        ),
        'MemberSkill' => array(
            'className' => 'MemberSkill',
            'foreignKey' => 'member_id'
        ),
        'MemberEmployer' => array(
            'className' => 'MemberEmployer',
            'foreignKey' => 'member_id'
        ),
        'Refer' => array(
            'className' => 'Refer',
            'foreignKey' => 'member_id'
        ),
        'MemberLanguage' => array(
            'className' => 'MemberLanguage',
            'foreignKey' => 'member_id'
        ),
        'MemberRecruitment' => array(
            'className' => 'MemberRecruitment',
            'foreignKey' => 'member_id'
        ),
    );
    public $hasOne = array(
        'Desire' => array(
            'className' => 'Desire',
            'foreignKey' => 'member_id'
        )
    );
    public $validate = array(
        'email' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Nhập địa chỉ email của bạn',
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Nhập đúng địa chỉ email của bạn'
            ),
            'isUnique' => array(
                'rule'    => array('isUnique'),
                'message' => 'Địa chỉ email này đã đăng ký tài khoản rồi',
                'on' => 'create'
            ),
        ),
        'fullname' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Họ tên không được để trống',
            ),
            'between' => array(
                'rule' => array('between', 5, 50),
                'message' => 'Họ tên từ %d đến %d ký tự',
            ),
        ),
        'phonenumber' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Số điện thoại không được để trống',
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Nhập đúng số điện thoại'
            ),
            'between' => array(
                'rule' => array('between', 10, 11),
                'message' => 'Nhập đúng số điện thoại',
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
    );

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
    public function isUniqueUsername($check)
    {
        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'Member.id',
                    'Member.username'
                ),
                'conditions' => array(
                    'Member.username' => $check['username']
                )
            )
        );
        if(!empty($username))
        {
            if($this->data[$this->alias]['id'] == $username['Member']['id'])
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }
    public function checkpassword($check)
    {
        $password = $this->find(
            'first',
            array(
                'fields' => array(
                    'Member.id',
                    'Member.password'
                ),
                'conditions' => array(
                    'Member.password' => AuthComponent::password($check['password_old'])
                )
            )
        );
        if(!empty($password))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function beforeSave($options = array()) {
        // hash our password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        // fallback to our parent
        return parent::beforeSave($options);
    }
}