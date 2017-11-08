<?php
class DegreesController extends AppController
{
    function _get_degrees_option()
    {
        $degrees = null;
        $this->Degree->recursive = -1;
        $degree = $this->Degree->find('all');
        if($degree)
        {
            foreach ($degree as $item)
            {
                $degrees[$item['Degree']['id']] = $item['Degree']['degree_name'];
            }
        }
        return $degrees;
    }
}