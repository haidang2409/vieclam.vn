<?php
class Order extends AppModel
{
    public $belongsTo = array(
        'Recruitment' => array(
            'className' => 'Recruitment',
            'foreignkey' => 'recruitment_id'
        ),
        'Packet' => array(
            'className' => 'Packet',
            'foreignKey' => 'packet_id'
        ),
        'Staff' => array(
            'className' => 'Staff',
            'foreignKey' => 'staff_id'
        )
    );
}