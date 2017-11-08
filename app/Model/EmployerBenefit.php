<?php
class EmployerBenefit extends AppModel
{
    public $useTable = 'employers_benefits';
    public $belongsTo = array(
        'Employer' => array(
            'className' => 'Employer',
            'foreignKey' => 'employer_id'
        ),
        'Benefit' => array(
            'className' => 'Benefit',
            'foreignKey' => 'benefit_id'
        )
    );
    //Validate
    public $validate = array(
        'benefit_id' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Vui lòng chọn phúc lợi'
            )
        )
    );
}