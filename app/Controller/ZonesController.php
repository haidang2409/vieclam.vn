<?php
class ZonesController extends AppController
{
    function _get_zones_option()
    {
        $zones = null;
        $this->Zone->recursive = -1;
        $zone = $this->Zone->find('all');
        if($zone)
        {
            foreach ($zone as $item)
            {
                $zones[$item['Zone']['id']] = $item['Zone']['zone_name'];
            }
        }
        return $zones;
    }


}