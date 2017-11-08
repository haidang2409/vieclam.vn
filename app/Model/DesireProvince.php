<?php
class DesireProvince extends AppModel
{
    public $useTable = 'desires_provinces';
    public $belongsTo = array(
        'Desire' => array(
            'className' => 'Desire',
            'foreignKey' => 'desire_id'
        ),
        'Province' => array(
            'className' => 'Province',
            'foreignKey' => 'province_id'
        )
    );
}