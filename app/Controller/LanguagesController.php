<?php
class LanguagesController extends AppController
{
    function _get_languages_option()
    {
        $languages = null;
        $this->Language->recursive = -1;
        $language = $this->Language->find('all');
        if($language)
        {
            foreach ($language as $item)
            {
                $languages[$item['Language']['id']] = $item['Language']['language_name'];
            }
        }
        return $languages;
    }
}