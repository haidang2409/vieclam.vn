<?php
class PostsCategoriesController extends AppController
{

    ////////////////////////
    ////////////////////////
    //Admin
    ////////////////////////
    ////////////////////////
    function admin_index()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $postcats = null;
        ClassRegistry::init('PostCategory')->recursive = -1;
        $postcats = ClassRegistry::init('PostCategory')->find('all');
        $this->set(array(
            'postcats' => $postcats,
            'title' => 'Chuyên mục bài viết'
        ));
    }
    function admin_add()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $this->set(array('title' => 'Thêm chuyên mục bài viết'));
        //post
        if($this->request->is('post') || $this->request->is('put'))
        {
            ClassRegistry::init('PostCategory')->set('link', $this->Library->make_link($this->request->data['PostCategory']['name']));
            if(ClassRegistry::init('PostCategory')->save($this->request->data))
            {
                $this->Session->setFlash('Đã thêm', 'flashSuccess');
                $this->redirect('/admin/posts_categories');
            }
            else
            {
                $this->Session->setFlash('Lỗi', 'flashError');
            }
        }
    }
    function admin_edit($id)
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        //
        ClassRegistry::init('PostCategory')->recursive = -1;
        $postcats = ClassRegistry::init('PostCategory')->findById($id);
        if($postcats)
        {
            $this->set(array(
                'postcats' => $postcats,
                'title' => 'Sửa chuyên mục bài viết'
            ));
        }
        else
        {
            $this->Session->setFlash('Not found', 'flashError');
            $this->redirect('/admin/posts_categories');
        }
        //post
        if($this->request->is('post') || $this->request->is('put'))
        {
            ClassRegistry::init('PostCategory')->set('id', $id);
            ClassRegistry::init('PostCategory')->set('link', $this->Library->make_link($this->request->data['PostCategory']['name']));
            if(ClassRegistry::init('PostCategory')->save($this->request->data))
            {
                $this->Session->setFlash('Đã sửa', 'flashSuccess');
                $this->redirect('/admin/posts_categories');
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
            $id = $this->request->data['postcat_id'];
            ClassRegistry::init('Post')->recursive = -1;
            $count = ClassRegistry::init('Post')->find('count', array(
                'conditions' => array('Post.post_category_id' => $id)
            ));
            if($count == 0)
            {
                if(ClassRegistry::init('PostCategory')->delete($id))
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