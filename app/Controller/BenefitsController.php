<?php
class BenefitsController extends AppController
{
    //Import

    //Member
    /////////////////////////
    function index()
    {
//        $this->is_login_employer();

        $this->Benefit->EmployerBenefit->recursive = -1;
        debug($this->Benefit->EmployerBenefit->find('all'));
    }

    //Employer
    /////////////////////////


    //Admin
    /////////////////////////

}