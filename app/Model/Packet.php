<?php
class Packet extends AppModel
{
    public $hasMany = array(
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'packet_id'
        )
    );
}