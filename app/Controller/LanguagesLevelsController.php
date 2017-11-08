<?php
class LanguagesLevelsController extends AppController
{
    public $name = 'LanguageLevel';
    function _get_languages_levels_option()
    {
        $languages_levels = null;
        $this->LanguageLevel->recursive = -1;
        $language_level = $this->LanguageLevel->find('all');
        if($language_level)
        {
            foreach ($language_level as $item)
            {
                $languages_levels[$item['LanguageLevel']['id']] = $item['LanguageLevel']['level_name'];
            }
        }
        return $languages_levels;
    }
}