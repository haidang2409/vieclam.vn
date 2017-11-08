<?php
App::uses('ZonesController', 'Controller');
class ProvincesController extends AppController
{
    //All
    function _get_province_option()
    {
        $provinces = null;
        $this->Province->recursive = -1;
        $province = $this->Province->find('all');
        if($province)
        {
            foreach ($province as $item)
            {
                $provinces[$item['Province']['id']] = $item['Province']['provincename'];
            }
        }
        return $provinces;
    }
    function _get_province_option_link()
    {
        $provinces = null;
        $this->Province->recursive = -1;
        $province = $this->Province->find('all');
        if($province)
        {
            foreach ($province as $item)
            {
                $provinces[$item['Province']['provincelink'] . '-p' . $item['Province']['id']] = $item['Province']['provincename'];
            }
        }
        return $provinces;
    }



    ///////////////
    //Admin
    function admin_index()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $this->Province->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'zones',
                    'alias' => 'Zone',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Province.zone_id = Zone.id'
                )
            ),
            'paramType' => 'querystring',
            'fields' => array('*'),
            'limit' => '10',
            'order' => array(
                'provincename' => 'ASC'
            ),
        );
        try
        {
            $provinces = $this->paginate('Province');
            if($provinces)
            {
                $this->set(
                    array(
                        'provinces' => $provinces
                    )
                );
            }
        }
        catch (NotFoundException $exception)
        {
            $this->Session->setFlash('Không tìm thấy trang theo yêu cầu', 'flashWarning');
        }
        $this->set(array('title' => 'Danh sách tỉnh thành'));
    }
    function admin_add()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $Zone = new ZonesController();
        $zones = $Zone->_get_zones_option();
        $this->set(array('title' => 'Thêm tỉnh thành', 'zones' => $zones));
        if($this->request->is('post') || $this->request->is('put'))
        {
            $this->Province->set('provincelink', $this->Library->make_link($this->request->data['Province']['provincename']));
            if($this->Province->save($this->request->data))
            {
                $this->Session->setFlash('Đã thêm', 'flashSuccess');
                $this->redirect('/admin/provinces');
            }
        }
    }
    function admin_edit($id)
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $provinces = $this->Province->findById($id);
        if(!$provinces)
        {
            $this->Session->setFlash('Không tìm thấy trang theo yêu cầu', 'flashWarning');
            $this->redirect('/admin/provinces');
        }
        $Zone = new ZonesController();
        $zones = $Zone->_get_zones_option();
        $this->set(array(
            'zones' => $zones,
            'provinces' => $provinces,
            'title' => 'Sửa tỉnh thành'
        ));
        if($this->request->is('post') || $this->request->is('put'))
        {
            $this->Province->set('provincelink', $this->Library->make_link($this->request->data['Province']['provincename']));
            if($this->Province->save($this->request->data))
            {
                $this->Session->setFlash('Đã sửa', 'flashSuccess');
                $this->redirect('/admin/provinces');
            }
        }
    }
    function admin_delete()
    {
        if($this->Session->check('Admin'))
        {
            $this->autoRender = false;
            $id = $this->request->data['province_id'];
            try
            {
                $this->Province->delete($id);
                $this->Session->setFlash('Đã xóa', 'flashSuccess');
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