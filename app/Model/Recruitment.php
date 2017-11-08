<?php
class Recruitment extends AppModel
{
    public $belongsTo = array(
        'Employer' => array(
            'className' => 'Employer',
            'foreignKey' => 'employer_id'
        ),
        'Level' => array(
            'className' => 'Level',
            'foreignKey' => 'level_id'
        ),
        'RecruitmentLanguage' => array(
            'className' => 'RecruitmentLanguage',
            'foreignKey' => 'recruitment_language_id'
        )
    );
    public $hasMany = array(
        'RecruitmentJob' => array(
            'className' => 'RecruitmentJob',
            'foreignKey' => 'recruitment_id'
        ),
        'RecruitmentProvince' => array(
            'className' => 'RecruitmentProvince',
            'foreignKey' => 'recruitment_id'
        ),
        'MemberRecruitment' => array(
            'className' => 'MemberRecruitment',
            'foreignKey' => 'recruitment_id'
        ),
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'recruitment_id'
        )

    );
    //Validation
    public $validate = array(
        'level_id' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Vui lòng chọn chức vụ'
            )
        ),
        'title' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập tiêu đề tin tuyển dụng'
            ),
            'between' => array(
                'rule' => array('between', 10, 70),
                'message' => 'Tiêu đề tin tuyển dụng phải từ %d đến %d ký tự'
            )
        ),
        'description' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Mô tả công việc không được để trống'
            ),
            'between' => array(
                'rule' => array('between', 1, 5000),
                'message' => 'Mô tả công việc phải từ %d đến %d ký tự'
            )
        ),
        'require' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Yêu cầu công việc không được để trống'
            ),
            'between' => array(
                'rule' => array('between', 10, 5000),
                'message' => 'Yêu cầu công việc phải từ %d đến %d ký tự'
            )
        ),
        'salary_min' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập mức lương tối thiểu'
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Vui lòng nhập đúng mức lương tối thiểu'
            )
        ),
        'salary_max' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Vui lòng nhập mức lương tối đa'
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Vui lòng nhập đúng mức lương tối đa'
            )
        ),


    );
    //////////////////////////////////////////////////
    //////////////////////////////////////////////////
    //Function
    public function beforeSave($options = array()) {
        // hash our password
        if (isset($this->data[$this->alias]['salary_min'])) {
            $this->data[$this->alias]['salary_min'] = str_replace(',', '', $this->data[$this->alias]['salary_min']);
        }
        if (isset($this->data[$this->alias]['salary_max'])) {
            $this->data[$this->alias]['salary_max'] = str_replace(',', '', $this->data[$this->alias]['salary_max']);
        }
        // fallback to our parent
        return parent::beforeSave($options);
    }
    public function beforeValidate($options = array()) {
        // hash our password
        if (isset($this->data[$this->alias]['salary_min'])) {
            $this->data[$this->alias]['salary_min'] = str_replace(',', '', $this->data[$this->alias]['salary_min']);
        }
        if (isset($this->data[$this->alias]['salary_max'])) {
            $this->data[$this->alias]['salary_max'] = str_replace(',', '', $this->data[$this->alias]['salary_max']);
        }
        // fallback to our parent
        return parent::beforeValidate($options);
    }


}