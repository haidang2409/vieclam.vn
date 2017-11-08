<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $helpers = array('Js' => array('Jquery'), 'Paginator', 'Lib', 'Html', 'Form', 'Session');//, 'DebugKit.Toolbar');
    public $components = array('RequestHandler', 'Paginator', 'Session', 'Cookie', 'Library', 'Mpdf');//, 'DebugKit.Toolbar');
    //////////////////////
    public $path_company_logo = '../webroot/uploads/company/logo';
    public $path_company_image = '../webroot/uploads/company/image';
    public $path_resume_file = '../webroot/resume';
    public $path_post = '../webroot/uploads/posts';
    //Path avatar member
    public $path_member_avatar = '../webroot/img/members';
    ///Commons
    public $_base_url_employer = '/nha-tuyen-dung';
    public $_base_url_admin = '/admin';

    public $_phone = '0901 032 320';
    public $_email = 'cskh@dream.edu.vn';
    //
    //Danh sách tin đã xem //Dùng Session cho Member
    function recruitment_viewed()
    {
        $recruitments_viewed = null;
        if($this->Session->check('S_ListViewed'))
        {
            $list_view = $this->Session->read('S_ListViewed');
            ClassRegistry::init('Recruitment')->recursive = -1;
            $recruitments_viewed = ClassRegistry::init('Recruitment')->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'employers',
                        'alias' => 'Employer',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'Recruitment.employer_id = Employer.id'
                    )
                ),
                'fields' => array(
                    'Recruitment.id',
                    'Recruitment.title',
                    'Recruitment.link',
                    'Employer.company_name'
                ),
                'limit' => 10,
                'conditions' => array(
                    'Recruitment.id' => $list_view
                )
            ));
        }
        return $recruitments_viewed;
    }
    //Danh sách ứng viên vừa ứng tuyển(Chưa xem) cho Employer -> header alert
    function get_candidate_new()
    {
        $candidate_new = null;
        if($this->Session->check('S_Employer'))
        {
            $employer_id = $this->Session->read('S_Employer.id');
            ClassRegistry::init('MemberRecruitment')->recursive = -1;
            $candidate_new = ClassRegistry::init('MemberRecruitment')->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'members',
                        'alias' => 'Member',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberRecruitment.member_id = Member.id'
                    ),
                    array(
                        'table' => 'recruitments',
                        'alias' => 'Recruitment',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => 'MemberRecruitment.recruitment_id = Recruitment.id'
                    )
                ),
                'fields' => array(
                    'Member.fullname',
                    'Member.id',
                    'Recruitment.title',
                    'MemberRecruitment.date_applied',
                    'MemberRecruitment.id'
                ),
                'conditions' => array(
                    'Recruitment.employer_id' => $employer_id,
                    'MemberRecruitment.is_viewed' => 0,
                    'MemberRecruitment.is_applied' => 1,
                ),
                'order' => array(
                    'MemberRecruitment.date_applied' => 'DESC'
                )
            ));
        }
        return $candidate_new;
    }
    //
    function beforeFilter()
    {
//        debug($this->request->clientIp());
//        header('X-Powered-By: SAMORINE');
        //header('Server: NHADAT');
        $this->_setLanguage();
        if(isset($this->params['prefix']) && $this->params['prefix'] == 'admin')
        {
            if($this->Session->check('Admin'))
            {
                $this->layout = 'admin_default';
            }
        }
        //Set url

        //Employer
        $candidate_new = $this->get_candidate_new();
        //
        $this->set(
            array(
                '_base_url_employer' => $this->_base_url_employer,
                '_base_url_admin' => $this->_base_url_admin,
                'candidate_new' => $candidate_new
            )
        );

    }

    //Đa ngôn ngữ
    function _setLanguage()
    {
        //Nếu có cookie
        if ($this->Cookie->read('lang') && !$this->Session->check('Config.language')) {
            $this->Session->write('Config.language', $this->Cookie->read('lang'));
        }
        elseif(isset($this->params['url']['language']) && ($this->params['url']['language'] != $this->Session->read('Config.language'))) {
            $this->Session->write('Config.language', $this->params['url']['language']);
            $this->Cookie->write('lang', $this->params['url']['language'], false, '60 minutes');
        }
    }
    //Check session
    function is_login_member()
    {
        if(!$this->Session->check('S_Member'))
        {
            $this->redirect('/');
        }
    }
    function is_login_employer()
    {
        if(!$this->Session->check('S_Employer'))
        {
            $this->redirect($this->_base_url_employer . '/dang-nhap');
        }
    }

    function get_curr_date()
    {
        $date = getdate();
        $curr_date = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'] . ' ' . $date['hours'] . ':' . $date['minutes'] . ':' . $date['seconds'];
        return $curr_date;
    }

}
