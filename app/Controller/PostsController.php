<?php
class PostsController extends AppController
{
    //////////////////////////
    //////////////////////////
    //User
    //////////////////////////
    //////////////////////////
    function index()
    {
        $postcat_link = isset($this->params['postcat'])? $this->params['postcat']: '';
        $postcat_id = isset($this->params['postcatid'])? $this->params['postcatid']: '';
        $conditions_category = '';
        if($postcat_link != '' && $postcat_id !='')
        {
            $conditions_category = 'PostCategory.id = "' . substr($postcat_id, 2) . '" AND PostCategory.link = "' . $postcat_link . '"';
        }
        //Breadcrumb cat
        $this->Post->PostCategory->recursive = -1;
        $breadcrumb_postcat = $this->Post->PostCategory->findById(substr($postcat_id, 2));
        $title = 'Tin tức việc làm';
        if($breadcrumb_postcat)
        {
            $title = $breadcrumb_postcat['PostCategory']['name'];
            $this->set(array('breadcrumb_postcat' => $breadcrumb_postcat));
        }
        $postcats = $this->Post->PostCategory->find('all');
        $this->set(array('postcats' => $postcats));
        $this->Post->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'staffs',
                    'alias' => 'Staff',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Post.staff_id = Staff.id'
                ),
                array(
                    'table' => 'posts_categories',
                    'alias' => 'PostCategory',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Post.post_category_id = PostCategory.id'
                ),
            ),
            'fields' => array('*'),
            'conditions' => array(
                $conditions_category,
                'Post.status' => 1
            ),
            'order' => array('Post.id' => 'DESC'),
            'limit' => 10,
            'paramType' => 'querystring'
        );
        //
        try
        {
            $posts = $this->paginate('Post');
            $this->set(array(
                'title' => $title,
                'posts' => $posts,
            ));
        }
        catch (NotFoundException $exception)
        {
//            $this->Session->setFlash('Không tìm thấy trang theo yêu cầu', 'flashWarning');
        }
    }
    function view($postlink, $id)
    {
        $this->Post->PostCategory->recursive = -1;
        $postcats = $this->Post->PostCategory->find('all');
        $this->Post->recursive = -1;
        $posts = $this->Post->find('first', array(
            'joins' => array(
                array(
                    'table' => 'staffs',
                    'alias' => 'Staff',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Post.staff_id = Staff.id'
                ),
                array(
                    'table' => 'posts_categories',
                    'alias' => 'PostCategory',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Post.post_category_id = PostCategory.id'
                ),
            ),
            'fields' => array('*'),
            'conditions' => array(
                'Post.id = ' . $id,
                'Post.postlink = "' . $postlink . '"',
                'Post.status' => 1
            )
        ));
        if(!$posts)
        {
            $this->redirect('/bai-viet');
        }
        //Update view
        $this->Post->query('UPDATE posts set view = view + 1 WHERE id = ' . $id);
        //Post relative
        $this->Post->recursive = -1;
        $posts_relatives = $this->Post->find('all', array(
            'joins' => array(
                array(
                    'table' => 'staffs',
                    'alias' => 'Staff',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Post.staff_id = Staff.id'
                ),
                array(
                    'table' => 'posts_categories',
                    'alias' => 'PostCategory',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Post.post_category_id = PostCategory.id'
                ),
            ),
            'fields' => array('*'),
            'conditions' => array(
                'Post.id != ' . $id,
                'Post.status' => 1
            ),
            'order' => array('Post.id' => 'desc'),
            'limit' => 5
        ));
        $this->Post->id = $id;
        $this->Post->recursive = -1;
        $post_prev_next = $this->Post->find('neighbors', array(
            'fields' => array('Post.id', 'Post.postlink'),
            'conditions' => array('Post.status' => 1),
            'order' => array('Post.id' => 'DESC')
        ));
        $this->set(array(
            'title' => $posts['Post']['title'],
            'head_description' => $posts['Post']['summary'],
            'og_image' => $posts['Post']['image'] != ''?  $_SERVER['HTTP_HOST'] . '/uploads/posts/' . $posts['Post']['image']: $_SERVER['HTTP_HOST'] . '/img/og_logo_default.jpg',
            'posts' => $posts,
            'postcats' => $postcats,
            'post_relatives' => $posts_relatives,
            'post_prev_next' => $post_prev_next
        ));

    }
    //////////////////////////
    //////////////////////////
    //Admin
    //////////////////////////
    //////////////////////////
    function admin_index()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        //
        //Set category
        $categories = null;
        $this->Post->PostCategory->recursive = -1;
        $category = $this->Post->PostCategory->find('all');
        foreach ($category as $item) {
            $categories[$item['PostCategory']['id']] = $item['PostCategory']['name'];
        }
        $this->set(array('categories' => $categories));
        //
        //Search
        $title_search = isset($this->params['url']['title'])? $this->params['url']['title']: '';
        $category_search = isset($this->params['url']['category'])? $this->params['url']['category']: '';
        $condition_title = $title_search != ''? 'Post.title LIKE "%' . $title_search . '%"': '';
        $condition_category = $category_search != ''? 'PostCategory.id =' . $category_search: '';
        //
        $this->Post->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'staffs',
                    'alias' => 'Staff',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Post.staff_id = Staff.id'
                ),
                array(
                    'table' => 'posts_categories',
                    'alias' => 'PostCategory',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Post.post_category_id = PostCategory.id'
                ),
            ),
            'fields' => array(
                'Post.*',
                'PostCategory.*',
                'Staff.fullname'
            ),
            'conditions' => array(
                $condition_title,
                $condition_category
            ),
            'order' => array('Post.id' => 'DESC'),
            'limit' => 10,
            'paramType' => 'querystring'
        );
        //
        try
        {
            $posts = $this->paginate('Post');
            $this->set(array(
                'title' => 'Danh sách bài viết',
                'posts' => $posts
            ));
        }
        catch (NotFoundException $exception)
        {

        }

    }
    function admin_add()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        //Post cat
        $postcats = null;
        $this->Post->PostCategory->recursive = -1;
        $postcat = $this->Post->PostCategory->find('all');
        foreach ($postcat as $item)
        {
            $postcats[$item['PostCategory']['id']] = $item['PostCategory']['name'];
        }
        $this->set(array(
            'title' => 'Thêm bài viết',
            'postcats' => $postcats
        ));
        //Post submit
        if($this->request->is('post'))
        {
            $postlink = $this->Library->make_link($this->request->data['Post']['title']);
            $staff_id = $this->Session->read('Admin.id');
            $this->Post->set('staff_id', $staff_id);
            $this->Post->set('postlink', $postlink);
            $this->Post->set('status', 1);
            //check image
            $images = $this->request->data['Post']['image2'];
            if($images['name'] != '')
            {
                if($images['type'] != 'image/png' && $images['type'] != 'image/jpeg')
                {
                    $this->Session->setFlash('Vui lòng chọn hình ảnh', 'flashWarning');
                    $this->redirect($_SERVER['REQUEST_URI']);
                }
                elseif ($images['size'] > 500000)
                {
                    $this->Session->setFlash('Vui lòng chọn hình ảnh < 500kb', 'flashWarning');
                    $this->redirect($_SERVER['REQUEST_URI']);
                }
            }
            //upload images
            $ext = pathinfo($images['name'], PATHINFO_EXTENSION);
            $time = new DateTime();
            $timestamp = $time->getTimestamp();
            $filename = $postlink.'-'.$timestamp.'.'.$ext;
            if($images['name'] != '')
            {
                $this->Post->set('image', $filename);
            }
            else
            {
                $this->Post->set('image', '');
            }
            if($this->Post->save($this->request->data))
            {
                move_uploaded_file($images['tmp_name'], $this->path_post.DS.$filename);
                $this->Session->setFlash('Đã lưu', 'flashSuccess');
                $this->redirect('/admin/posts');
            }
        }
    }
    function admin_edit($id)
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        //Product
        $this->Post->recursive = -1;
        $posts = $this->Post->findById($id);
        if(!$posts)
        {
            $this->redirect('/admin/posts');
        }
        //Post cat
        $postcats = null;
        $this->Post->PostCategory->recursive = -1;
        $postcat = $this->Post->PostCategory->find('all');
        foreach ($postcat as $item)
        {
            $postcats[$item['PostCategory']['id']] = $item['PostCategory']['name'];
        }
        $this->set(array(
            'postcats' => $postcats,
            'posts' => $posts,
            'title' => 'Sửa bài viết'
        ));
        //Post submit
        if($this->request->is('post') || $this->request->is('put'))
        {
            $postlink = $this->Library->make_link($this->request->data['Post']['title']);
            $staff_id = $this->Session->read('Admin.id');
            $this->Post->set('staff_id', $staff_id);
            $this->Post->set('postlink', $postlink);
            //check image
            $images = $this->request->data['Post']['image2'];
            if($images['name'] != '')
            {
                if($images['type'] != 'image/png' && $images['type'] != 'image/jpeg')
                {
                    $this->Session->setFlash('Vui lòng chọn hình ảnh', 'flashWarning');
                    $this->redirect($_SERVER['REQUEST_URI']);
                }
                elseif ($images['size'] > 500000)
                {
                    $this->Session->setFlash('Vui lòng chọn hình ảnh < 500kb', 'flashWarning');
                    $this->redirect($_SERVER['REQUEST_URI']);
                }
            }
            //upload images
            $ext = pathinfo($images['name'], PATHINFO_EXTENSION);
            $time = new DateTime();
            $timestamp = $time->getTimestamp();
            $filename = $postlink.'-'.$timestamp.'.'.$ext;
            if($images['name'] != '')
            {
                $this->Post->set('image', $filename);
                if(file_exists($this->path_post.DS.$this->request->data['Post']['image_old']))
                {
                    unlink($this->path_post.DS.$this->request->data['Post']['image_old']);
                }
            }
            else
            {
                $this->Post->set('image', $this->request->data['Post']['image_old']);
            }

            if($this->Post->save($this->request->data))
            {
                debug($this->request->data);
                move_uploaded_file($images['tmp_name'], $this->path_post.DS.$filename);
                $this->Session->setFlash('Đã lưu', 'flashSuccess');
                $this->redirect('/admin/posts');
            }
        }
    }
    function admin_view($id)
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $this->Post->recursive = -1;
        $posts = $this->Post->find('first', array(
            'joins' => array(
                array(
                    'table' => 'staffs',
                    'alias' => 'Staff',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Post.staff_id = Staff.id'
                ),
                array(
                    'table' => 'posts_categories',
                    'alias' => 'PostCategory',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Post.post_category_id = PostCategory.id'
                ),
            ),
            'fields' => array('*'),
            'conditions' => array('Post.id = ' . $id)
        ));
        if(!$posts)
        {
            $this->redirect('/admin/posts');
        }
        $this->set(array(
            'title' => 'Chi tiết bài viết',
            'posts' => $posts
        ));
    }
    function admin_delete()
    {
        $this->autoRender = false;
        if($this->Session->check('Admin'))
        {
            $id = $this->request->data['post_id'];
            if($this->Post->delete($id))
            {
                $this->Session->setFlash('Đã xóa', 'flashSuccess');
            }
        }
        else
        {
            $this->Session->setFlash('Lỗi', 'flashError');
        }
    }

}