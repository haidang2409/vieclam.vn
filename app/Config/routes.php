<?php
$_base_url_employer = '/nha-tuyen-dung';
Router::parseExtensions('html', 'rss');
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
//////////////////////////////////
//Front-End
//////////////////////////////////
//User
//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/', array('controller' => 'recruitments', 'actions' => 'index'));
Router::connect('/tim-kiem-viec-lam', array('controller' => 'recruitments', 'actions' => 'index_recruitment'));
Router::connect('/dang-ky', array('controller' => 'members', 'action' => 'register'));
Router::connect('/dang-nhap', array('controller' => 'members', 'action' => 'login'));
Router::connect('/dang-xuat', array('controller' => 'members', 'action' => 'logout'));
Router::connect('/active_email', array('controller' => 'members', 'action' => 'active_email'));

Router::connect('/tim-viec-lam', array('controller' => 'recruitments', 'action' => 'index_recruitment'));


Router::connect('/tim-viec-lam/:job_link-:job_id/:province_link-:province_id',
    array(
        'controller' => 'recruitments',
        'action' => 'index_recruitment'
    ),
    array(
        'pass' => array('job_link', 'job_id', 'province_link', 'province_id'),
        'job_link' => '[a-z0-9-]+',
        'job_id' => '[j][0-9]+',
        'province_link' => '[a-z0-9-]+',
        'province_id' => '[p][0-9]+'
    )
);
Router::connect('/tim-viec-lam/:job_link-:job_id',
    array(
        'controller' => 'recruitments',
        'action' => 'index_recruitment'
    ),
    array(
        'pass' => array('job_link', 'job_id'),
        'job_link' => '[a-z0-9-]+',
        'job_id' => '[j][0-9]+',
    )
);
Router::connect('/tim-viec-lam/:province_link-:province_id',
    array(
        'controller' => 'recruitments',
        'action' => 'index_recruitment'
    ),
    array(
        'pass' => array('province_link', 'province_id'),
        'province_link' => '[a-z0-9-]+',
        'province_id' => '[p][0-9]+'
    )
);

Router::connect('/tim-viec-lam/nha-tuyen-dung/:company_link-:company_id',
    array(
        'controller' => 'recruitments',
        'action' => 'index_recruitment'
    ),
    array(
        'pass' => array('company_link', 'company_id'),
        'company_link' => '[a-z0-9-]+',
        'company_id' => '[0-9]+'
    )
);
//Chi tiết tuyển dụng
Router::connect('/tim-viec-lam/:link/:id',
    array(
        'controller' => 'recruitments',
        'action' => 'view'
    ),
    array(
        'pass' => array('link', 'id'),
        'link' => '[a-z0-9-]+',
        'id' => '[0-9]+'
    )
);

//Profile
Router::connect('/cap-nhat-tai-khoan', array('controller' => 'members', 'action' => 'update_profile'));
Router::connect('/cap-nhat-ho-so', array('controller' => 'members', 'action' => 'update_resume'));
Router::connect('/cong-viec-da-luu', array('controller' => 'members', 'action' => 'recruitments_saved'));
Router::connect('/nha-tuyen-dung-xem-ho-so', array('controller' => 'members', 'action' => 'employer_view_resume'));
//Bài viết
Router::connect('/bai-viet', array('controller' => 'posts', 'action' => 'index'));
Router::connect('/bai-viet/:postcat-:postcatid',
    array('controller' => 'posts', 'action' => 'index'),
    array(
        'pass' => array('postcat', 'postcatid'),
        'postcat' => '[a-z0-9-]+',
        'postcatid' => '[c][p][0-9]+'
    )
);
Router::connect('/bai-viet/:postlink-:id',
    array('controller' => 'posts', 'action' => 'view'),
    array(
        'pass' => array('postlink', 'id'),
        'postlink' => '[a-z0-9-]+',
        'id' => '[0-9-]+'
    )
);




//Employer
Router::connect($_base_url_employer . '/dang-ky', array('controller' => 'employers', 'action' => 'register'));
Router::connect($_base_url_employer . '/active_email', array('controller' => 'employers', 'action' => 'active_email'));
Router::connect($_base_url_employer . '/dang-nhap', array('controller' => 'employers', 'action' => 'login'));
Router::connect($_base_url_employer . '/dang-xuat', array('controller' => 'employers', 'action' => 'logout'));

Router::connect($_base_url_employer, array('controller' => 'employers', 'action' => 'index'));
Router::connect($_base_url_employer . '/manager', array('controller' => 'employers', 'action' => 'manager'));
Router::connect($_base_url_employer . '/tai-khoan', array('controller' => 'employers', 'action' => 'profile'));
Router::connect($_base_url_employer . '/dang-viec-lam', array('controller' => 'recruitments', 'action' => 'add'));
Router::connect($_base_url_employer . '/sua-viec-lam/:recruitment_id',
    array(
        'controller' => 'recruitments',
        'action' => 'edit'
    ),
    array(
        'pass' => array('recruitment_id'),
        'recruitment_id' => '[0-9]+'
    )
);
Router::connect($_base_url_employer . '/viec-lam', array('controller' => 'employers', 'action' => 'job'));
Router::connect($_base_url_employer . '/viec-lam/tin-nhap', array('controller' => 'employers', 'action' => 'job', 'status' => 'draft'));
Router::connect($_base_url_employer . '/viec-lam/dang-an', array('controller' => 'employers', 'action' => 'job', 'status' => 'hidden'));
Router::connect($_base_url_employer . '/viec-lam/het-han', array('controller' => 'employers', 'action' => 'job', 'status' => 'expried'));
Router::connect($_base_url_employer . '/ho-so-ung-vien', array('controller' => 'employers', 'action' => 'candidate'));
Router::connect($_base_url_employer . '/ho-so-ung-vien/:member_recruitment_id',
    array(
        'controller' => 'members',
        'action' => 'view_member_applied',
    ),
    array(
        'pass' => array('member_recruitment_id'),
        'member_recruitment_id' => '[0-9]+'
    )
);
Router::connect($_base_url_employer . '/ho-so-da-luu', array('controller' => 'employers', 'action' => 'resume_saved'));
Router::connect($_base_url_employer . '/ho-so-da-luu/:member_employer_id',
    array(
        'controller' => 'members',
        'action' => 'view_resume_saved',
    ),
    array(
        'pass' => array('member_employer_id'),
        'member_employer_id' => '[0-9]+'
    )
);
Router::connect($_base_url_employer . '/tim-ung-vien', array('controller' => 'members', 'action' => 'search_resume'));
Router::connect($_base_url_employer . '/tim-ung-vien/detail/:member_id',
    array(
        'controller' => 'members',
        'action' => 'view_resume_search',
    ),
    array(
        'pass' => array('member_id'),
        'member_id' => '[0-9]+'
    )
);
Router::connect($_base_url_employer . '/in-ho-so/:member_id',
    array(
        'controller' => 'members',
        'action' => 'print_resume',
    ),
    array(
        'pass' => array('member_id'),
        'member_id' => '[0-9]+'
    )
);
Router::connect($_base_url_employer . '/thay-doi-logo', array('controller' => 'employers', 'action' => 'change_logo'));
Router::connect($_base_url_employer . '/quen-mat-khau', array('controller' => 'employers', 'action' => 'forget_password'));
Router::connect($_base_url_employer . '/dat-lai-mat-khau', array('controller' => 'employers', 'action' => 'reset_password'));
Router::connect($_base_url_employer . '/change_password_status', array('controller' => 'employers', 'action' => 'change_password_status'));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */

/////////////////////////////////////
//Back-End
/////////////////////////////////////
Router::connect('/admin', array('controller' => 'staffs', 'action' => 'login', 'prefix' => 'admin',));
Router::connect('/admin/home', array('controller' => 'staffs', 'action' => 'home', 'prefix' => 'admin',));
Router::connect('/admin/login', array('controller' => 'staffs', 'action' => 'login', 'prefix' => 'admin', 'admin' => false));
Router::connect('/admin/logout', array('controller' => 'staffs', 'action' => 'logout', 'prefix' => 'admin'));
//Members




///////////////////////////////////
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
