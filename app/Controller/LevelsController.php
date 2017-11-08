<?php
class LevelsController extends AppController
{
    function _get_levels_option()
    {
        $levels = null;
        $this->Level->recursive = -1;
        $level = $this->Level->find('all');
        if($level)
        {
            foreach ($level as $item)
            {
                $levels[$item['Level']['id']] = $item['Level']['levelname'];
            }
        }
        return$levels;
    }

}