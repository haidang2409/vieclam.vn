<?php
class Zone extends AppModel
{
    public $hasMany = array(
        'Province' => array(
            'className' => 'Province',
            'foreignKey' => 'zone_id'
        )
    );
}