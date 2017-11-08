<!DOCTYPE html>
<html lang="vi">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php if(isset($title)){ echo $title;} else { echo 'Tìm việc làm Cần Thơ';} echo ' - ' . $_SERVER['HTTP_HOST'];?>
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <?php
    $default_keywords = '';
    $default_description = 'Kênh tìm kiếm việc làm';
    $default_title = '';
    echo $this->Html->meta('keywords', isset($keywords)? $keywords: $default_keywords);
    echo $this->Html->meta('description', isset($head_description)? $head_description: $default_description);
    echo $this->Html->meta('icon');
//    echo $this->Html->css('bootstrap');
//    echo $this->Html->css('font-awesome.min');
//    echo $this->Html->css('font_custom');
//    echo $this->Html->css('bootstrap-custom');
//    echo $this->Html->css('select2.min');
//    echo $this->Html->css('colorbox.min');
//    echo $this->Html->css('ace.min');
//    echo $this->Html->css('jquery-ui.min');
//    echo $this->Html->css('home_style');
    echo $this->Html->css('app_common');
    echo $this->Html->css('style');
    echo $this->Html->script('jquery-2.1.4.min', array());
    echo $this->Js->writeBuffer();
    ?>
</head>
<body>
<?php
$action = $this->params['action'];
include ('analyticstracking.ctp');
?>

<div class="" style="background-color: #199EB8">
    <nav class="container navbar-custom navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/" style="padding-top: 3px; padding-bottom: 3px">
                <img src="/img/logo_primary_xs.png" height="44px">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?php if($action == 'job'){ echo 'active';}?>">
                    <a href="/tim-viec-lam">
                        <span class="fa fa-file-text-o"> </span>
                        Tất cả việc làm
                    </a>
                </li>
                <li>
                    <a href="<?php echo $_base_url_employer?>/">
                        Nhà tuyển dụng
                    </a>
                </li>
                <li>
                    <a href="/bai-viet">
                        Bài viết
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="fa fa-bell"></span>
                        Thông báo
                        <span class="label label-warning sum-bell"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-bell navbar-right-has-direction container-alert-bell">
                    </ul>
                </li>
                <li class="dropdown">
                    <?php
                    if($this->Session->check('S_Member'))
                    {
                        $img = $this->Session->read('S_Member.avatar');
                        if(!file_exists(WWW_ROOT . '/img/members/' . $img) || $img == '')
                        {
                            $img = 'default_user.jpg';
                        }
                        ?>
                        <a style="padding-top: 0; padding-bottom: 0" href="#" class="dropdown-toggle dropdown-toggle-profile" data-toggle="dropdown">
                            <img class="img-circle" src="/img/members/<?php echo $img?>" width="50px" height="50px">
                            <b class="caret visible-xs"></b>
                        </a>
                        <ul class="dropdown-menu navbar-right-has-direction dropdown-profile">
                            <li>
                                <a href="/cap-nhat-ho-so">
                                    <span class="fa fa-file-text"> </span>
                                    Hồ sơ
                                </a>
                            </li>
                            <li>
                                <a href="/cap-nhat-tai-khoan">
                                    <span class="fa fa-user"> </span>
                                    Tài khoản
                                </a>
                            </li>
                            <li>
                                <a href="/cong-viec-da-luu">
                                    <span class="fa fa-file-text"> </span>
                                    Công việc đã lưu
                                </a>
                            </li>
                            <li>
                                <a href="/nha-tuyen-dung-xem-ho-so">
                                    <span class="fa fa-file-text"> </span>
                                    Nhà tuyển dụng xem hồ sơ
                                </a>
                            </li>
                            <li>
                                <a href="/thiet-lap">
                                    <span class="fa fa-cog"> </span>
                                    Thiết lập
                                </a>
                            </li>
                            <li>
                                <a href="/dang-xuat">
                                    <span class="glyphicon glyphicon-off"></span>
                                    Đăng xuất
                                </a>
                            </li>
                        </ul>
                        <?php
                    }
                    else
                    {
                        ?>
                        <a href="/dang-nhap">
                            <span class="fa fa-sign-in"></span>
                            Đăng nhập
                        </a>
                        <?php
                    }
                    ?>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</div>


