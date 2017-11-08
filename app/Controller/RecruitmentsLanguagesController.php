<?php
class RecruitmentsLanguagesController extends AppController
{
    public $name = 'RecruitmentLanguage';
    function _get_recruitment_language()
    {
        $recruitments_languages = null;
        $this->RecruitmentLanguage->recursive = -1;
        $recruitment_language = $this->RecruitmentLanguage->find('all');
        if($recruitment_language)
        {
            foreach ($recruitment_language as $item)
            {
                $recruitments_languages[$item['RecruitmentLanguage']['id']] = $item['RecruitmentLanguage']['recruitment_language_name'];
            }
        }
        return $recruitments_languages;
    }
}