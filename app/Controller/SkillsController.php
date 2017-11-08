<?php
class SkillsController extends AppController
{
    function _get_skills_option()
    {
        $this->Skill->recursive = -1;
        $skill = $this->Skill->find('all');
        $skills = null;
        if($skill)
        {
            foreach ($skill as $item)
            {
                $skills[$item['Skill']['id']] = $item['Skill']['skill_name'];
            }
        }
        return $skills;
    }
}