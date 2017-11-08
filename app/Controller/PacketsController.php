<?php
App::uses('CakeEmail', 'Network/Email');
class PacketsController extends AppController
{

    public $components = array('Session', 'Library', 'Mailtemplate');
    ///////////////////////////////////
    ///////////////////////////////////
    //User
    ///////////////////////////////////
    ///////////////////////////////////



    ////////////////////////////////////////
    ////////////////////////////////////////
    //Admin
    ////////////////////////////////////////
    ////////////////////////////////////////
    public function admin_index()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $this->Packet->recursive = -1;
        $packets = $this->Packet->find('all');
        $this->set(array(
            'title' => 'Dịch vụ đăng tin',
            'packets' =>  $packets
        ));
    }
    public function admin_add()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $this->set(array('title' => 'Thêm dịch vụ'));
        //post
        if($this->request->is('post') || $this->request->is('put'))
        {
            if($this->Packet->save($this->request->data))
            {
                $this->Session->setFlash('Đã thêm', 'flashSuccess');
                $this->redirect('/admin/packets');
            }
        }
    }
    public function admin_edit($id)
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        //Set
        $packets = $this->Packet->findById($id);
        if(!$packets)
        {
            $this->Session->setFlash('Not found', 'flashError');
            $this->redirect('/admin/packets');
        }
        $this->set(array(
            'packets' => $packets,
            'title' => 'Sửa gói tin'
        ));
        //post
        if($this->request->is('post') || $this->request->is('put'))
        {
            $this->Packet->set('id', $id);
            if($this->Packet->save($this->request->data))
            {
                $this->Session->setFlash('Đã sửa', 'flashSuccess');
                $this->redirect('/admin/packets');
            }
        }
    }
    public function admin_delete()
    {
        $this->autoRender = false;
        if($this->Session->check('Admin'))
        {
            $id = $this->request->data['packet_id'];
            $count = $this->Packet->Order->find('count', array(
                'conditions' => array('Order.packet_id' => $id)
            ));
            if($count == 0)
            {
                if($this->Packet->delete($id))
                {
                    $this->Session->setFlash('Đã xóa', 'flashSuccess');
                }
            }
            else
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