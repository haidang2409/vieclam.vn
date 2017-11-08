<?php
class JobsController extends AppController
{
    //Import

    //All
    function _get_jobs_option()
    {
        $jobs = null;
        $this->Job->recursive = -1;
        $job = $this->Job->find('all', array(
            'conditions' => array()
        ));
        if($job)
        {
            foreach ($job as $item)
            {
                $jobs[$item['Job']['id']] = $item['Job']['jobname'];
            }
        }
        return $jobs;
    }
    function _get_jobs_option_link()
    {
        $jobs = null;
        $this->Job->recursive = -1;
        $job = $this->Job->find('all', array(
            'conditions' => array()
        ));
        if($job)
        {
            foreach ($job as $item)
            {
                $jobs[$item['Job']['joblink'] . '-j' . $item['Job']['id']] = $item['Job']['jobname'];
            }
        }
        return $jobs;
    }
    ////////////////////////////
    //User



    ////////////////////////////
    //Employer



    ////////////////////////////
    //Admin
    function admin_index()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        //
        $jobs = null;
        $this->Job->recursive = -1;
        $this->paginate = array(
            'paramType' => 'querystring',
            'fields' => array('*'),
            'limit' => '10',
            'order' => array(
                'jobname' => 'ASC'
            ),
        );
        try
        {
            $jobs = $this->paginate('Job');
            $this->set(
                array(
                    'jobs' => $jobs
                )
            );
        }
        catch (NotFoundException $exception)
        {

        }
        $this->set(array(
            'title' => 'Ngành nghề tuyển dụng'
        ));
    }
    function admin_add()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        //
        $this->set(array(
            'title' => 'Thêm ngành nghề tuyển dụng'
        ));
        //Post
        if($this->request->is('post'))
        {
            $this->Job->set('joblink', $this->Library->make_link($this->request->data['Job']['jobname']));
            if($this->Job->save($this->request->data))
            {
                $this->Session->setFlash('Thêm thành công', 'flashSuccess');
                $this->redirect('/admin/jobs');
            }
        }
    }
    function admin_edit($id)
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        //Category
        $this->Job->recursive = -1;
        $jobs = $this->Job->findById($id);
        if(!$jobs)
        {
            $this->Session->setFlash('Không tìm thấy trang theo yêu cầu', 'flashWarning');
            $this->redirect('/admin/jobs');
        }
        //
        $this->set(array(
            'jobs' => $jobs,
            'title' => 'Sửa ngành nghề'
        ));
        //Post
        if($this->request->is('post') || $this->request->is('put'))
        {
            $this->Job->set('joblink', $this->Library->make_link($this->request->data['Job']['jobname']));
            $this->Job->set('id', $id);
            if($this->Job->save($this->request->data))
            {
                $this->Session->setFlash('Sửa thành công', 'flashSuccess');
                $this->redirect('/admin/jobs');
            }
            else
            {
                $this->Session->setFlash('Lỗi', 'flashError');
            }
        }
    }
    function admin_delete()
    {
        if($this->Session->check('Admin'))
        {
            $this->autoRender = false;
            $id = $this->request->data['job_id'];
            try
            {
                if($this->Job->delete($id))
                {
                    $this->Session->setFlash('Đã xóa', 'flashSuccess');
                }
            }
            catch (Exception $exception)
            {
                $this->Session->setFlash('Không thể xóa', 'flashError');
            }
        }
        else
        {
            $this->Session->setFlash('Lỗi', 'flashError');
        }
    }



}