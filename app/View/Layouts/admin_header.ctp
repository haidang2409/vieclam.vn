<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>
        <?php if(isset($title)){ echo $title;} else { echo 'Quản trị hệ thống';} echo ' - ' . $_SERVER['HTTP_HOST'];?>
    </title>
    <meta name="description" content="Hệ thống quản lý" />
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="../../public/images/dream1.ico">
    <?php
    //Css
    echo $this->Html->css('bootstrap');
    echo $this->Html->css('jquery-ui.min');
    echo $this->Html->css('font-awesome.min');
    echo $this->Html->css('admin_ace.min');
    echo $this->Html->css('select2.min');
    echo $this->Html->css('admin-style');
    echo $this->Html->css('font');
    echo $this->Html->css('fullcalendar.min');
    echo $this->Html->css('ace-skins.min');
    //Scrpit
    echo $this->Html->script('jquery-2.1.4.min');
    echo $this->Js->writeBuffer();
    ?>
</head>
<body class="skin-2">
<div id="spinner">
    <i class="fa fa-spin fa-spinner"></i>
</div>
<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="navbar-header pull-left">
            <a href="/admin" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    BĐS Admin
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <?php
                        $img = '/img/ad/staffs/default_user.jpg';
                        if($this->Session->read('Admin.image') != '' && file_exists(WWW_ROOT . 'img/ad/staffs/' . $this->Session->read('Admin.image')))
                        {
                            $img = '/img/ad/staffs/' . $this->Session->read('Admin.image');
                        }
                        ?>
                        <img  class="nav-user-photo img-circle" src="<?php echo $img;?>" alt="<?php echo $this->Session->read('Admin.fullname');?>" title="<?php echo $this->Session->read('Admin.fullname');?>" />
                        <span class="user-info">
                            <small>Xin chào,</small>
                            <?php
                            $str = $this->Session->read('Admin.fullname');
                            $str = trim($str);
                            $start = strripos($str, ' ');
                            if($start > 0)
                            {
                                echo substr($str, $start + 1, strlen($str));
                            }
                            else
                            {
                                echo $str;
                            }
                            ?>
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="#">
                                <i class="ace-icon fa fa-cog"></i>
                                Thiết lập
                            </a>
                        </li>

                        <li>
                            <a href="/admin/staffs/my_profile">
                                <i class="ace-icon fa fa-user"></i>
                                Tài khoản
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="/admin/logout">
                                <i class="ace-icon fa fa-power-off"></i>
                                Đăng xuất
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>

<div class="main-container ace-save-state" id="main-container">
    <div id="sidebar" class="sidebar responsive ace-save-state <?php if(isset($_SESSION['min-menu']) && $_SESSION['min-menu'] == 'true'){ echo 'menu-min';}?>">
        <!--Menu trái-->
        <!--        include menu-->
        <?php
        include 'admin_menu1.ctp';
        ?>
    </div>

