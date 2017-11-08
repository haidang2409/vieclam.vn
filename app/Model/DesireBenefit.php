<?php
//Phúc lợi mong muốn
class DesireBenefit extends AppModel
{
    public $useTable = 'desires_benefits';
    public $belongsTo = array(
        'Desire' => array(
            'className' => 'Desire',
            'foreignKey' => 'desire_id'
        ),
        'Benefit' => array(
            'className' => 'Benefit',
            'foreignKey' => 'benefit_id'
        )
    );
}