<?php
class EmployersBenefitsController extends AppController
{
    public $name = 'EmployerBenefit';
    function update_benefit()
    {
        $this->is_login_employer();
        $this->layout = 'employer_default';
        $employer_id = $this->Session->read('S_Employer.id');
        $this->EmployerBenefit->recursive = -1;
        $employers_benefits = $this->EmployerBenefit->find('all', array(
            'joins' => array(
                array(
                    'table' => 'benefits',
                    'alias' => 'Benefit',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'EmployerBenefit.benefit_id = Benefit.id'
                )
            ),
            'fields' => array('*'),
            'conditions' => array(
                'EmployerBenefit.employer_id' => $employer_id
            )
        ));
        $this->EmployerBenefit->Benefit->recursive = -1;
        $benefits = $this->EmployerBenefit->Benefit->find('all');
        $this->set(array(
            'title' => 'Cập nhật phúc lợi',
            'benefits' => $benefits,
            'employers_benefits' => $employers_benefits
        ));
        //Post
        if($this->request->is('post'))
        {
            $arr_benefit_id = isset($this->request->data['benefit_id'])? $this->request->data['benefit_id']: null;
            $arr_benefit_note = isset($this->request->data['benefit_note'])? $this->request->data['benefit_note']: null;
            if(count($arr_benefit_id) > 0 && count($arr_benefit_note) > 0)
            {
                //Xóa dữ liệu cũ
                $this->EmployerBenefit->deleteAll(array('EmployerBenefit.employer_id' => $employer_id));
                //Thêm dữ liệu mới
                $sum = 5;
                if(count($arr_benefit_id) < 5)
                {
                    $sum = count($arr_benefit_id);
                }
                for($i = 0; $i < $sum; $i++)
                {
                    if($arr_benefit_id[$i] != '' && $arr_benefit_note != '')
                    {
                        $this->EmployerBenefit->set('employer_id', $employer_id);
                        $this->EmployerBenefit->set('benefit_id', $arr_benefit_id[$i]);
                        $this->EmployerBenefit->set('note', $arr_benefit_note[$i]);
                        try
                        {
                            $this->EmployerBenefit->saveAll();
                        }
                        catch (Exception $exception)
                        {

                        }
                    }
                }
                $this->Session->setFlash('Đã cập nhật', 'flashSuccess');
                $this->redirect('/nha-tuyen-dung/phuc-loi-cong-ty');
            }
            else
            {
                $this->Session->setFlash('Vui lòng chọn phúc lợi', 'flashWarning');
            }

        }
    }
}