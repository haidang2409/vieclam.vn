<!DOCTYPE html>
<html lang="vi">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php if(isset($title)){ echo $title;} else { echo 'Việc làm Cần Thơ';} echo ' - ' . $_SERVER['HTTP_HOST'];?>
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <?php
    $default_keywords = '';
    $default_description = '';
    $default_title = '';
    echo $this->Html->meta('keywords', isset($keywords)? $keywords: $default_keywords);
    echo $this->Html->meta('description', isset($head_description)? $head_description: $default_description);
    echo $this->Html->meta('icon');
    echo $this->Html->css('bootstrap');
    echo $this->Html->css('font-awesome.min');
    echo $this->Html->css('font_custom');
    echo $this->Html->css('bootstrap-custom');
    echo $this->Html->css('select2.min');
    echo $this->Html->css('colorbox.min');
    echo $this->Html->css('ace.min');
    echo $this->Html->css('jquery-ui.min');
    echo $this->Html->css('style_employers');
    echo $this->Html->css('home_style');
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
            <a class="navbar-brand" href="/nha-tuyen-dung" style="padding-top: 3px; padding-bottom: 3px">
                <img src="/img/logo_primary_xs.png" height="44px">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?php if($action == 'job'){ echo 'active';}?>">
                    <a href="<?php echo $_base_url_employer . '/viec-lam';?>">
                        <span class="fa fa-file-text-o"> </span>
                        Việc làm
                    </a>
                </li>
<!--                <li>-->
<!--                    <a href="/nha-tuyen-dung/lich-lam-viec">-->
<!--                        <span class="glyphicon glyphicon-calendar"></span>-->
<!--                        Lịch làm việc-->
<!--                    </a>-->
<!--                </li>-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="fa fa-list"></span>
                        Hồ sơ <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu navbar-left-has-direction">
                        <li>
                            <a href="<?php echo $_base_url_employer;?>/ho-so-ung-vien">
                                <i class="fa fa-user"></i>
                                Hồ sơ dự tuyển
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $_base_url_employer;?>/ho-so-da-luu">
                                <i class="fa fa-save"></i>
                                Hồ sơ đã lưu
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo $_base_url_employer;?>/tim-ung-vien">
                                <i class="fa fa-search"></i>
                                Tìm ứng viên
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $_base_url_employer;?>/hoa-don">
                        Hóa đơn
                    </a>
                </li>
                <li>
                    <a style="font-weight: bold" href="<?php echo $_base_url_employer;?>/dang-viec-lam">
                        ĐĂNG TUYỂN DỤNG
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        if(isset($candidate_new) && count($candidate_new) > 0)
                        {
                            echo '<span class="fa fa-bell"></span> Thông báo ';
                            echo '<span class="label label-warning">' . count($candidate_new) . '</span>';
                        }
                        else
                        {
                            echo '<span class="fa fa-bell-o"></span> Thông báo';
                        }
                        ?>
                    </a>
                    <?php
                    if(isset($candidate_new) && count($candidate_new) > 0)
                    {
                        $alert_limit = 5;
                        if(count($candidate_new) < 5)
                        {
                            $alert_limit = count($candidate_new);
                        }
                        ?>
                        <ul class="dropdown-menu container-alert-bell navbar-right-has-direction" id="container-alert-bell">
                            <?php
                            for($i = 0; $i < $alert_limit; $i++)
                            {
                                $item = $candidate_new[$i];
                                ?>
                                <li class="li-alert-item">
                                    <a href="/nha-tuyen-dung/ho-so-ung-vien/<?php echo $item['MemberRecruitment']['id'];?>">
                                        <?php
                                        echo '<span class="bolder name">' . htmlentities($item['Member']['fullname'], ENT_QUOTES, 'UTF-8') . ' </span>';
                                        echo 'đã ứng tuyển ' . $item ['Recruitment']['title'];?>
                                        -
                                        <span class="orange2"><?php echo $this->Lib->convertDateTime_Mysql_to_Date($item['MemberRecruitment']['date_applied']);?></span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <li class="divider visible-xs"></li>
                            <li class="li-alert-all"><a href="/nha-tuyen-dung/ho-so-ung-vien" class="text-center">Xem tất cả</a></li>
                        </ul>
                        <?php
                    }
                    else
                    {
                        ?>
                        <ul class="dropdown-menu container-alert-bell navbar-right-has-direction">
                            <li class="not-alert-item"><a href="javascript: void(0)">Không có thông báo mới</a> </li>
                        </ul>
                        <?php
                    }
                    ?>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="fa fa-user">

                        </span>
                        Tài khoản <b class="caret"></b>
                    </a>
                    <?php
                    if($this->Session->check('S_Employer'))
                    {
                        ?>
                        <ul class="dropdown-menu navbar-right-has-direction">
                            <li><a href="<?php echo $_base_url_employer;?>/tai-khoan">
                                    <span class="fa fa-user"> </span>
                                    Tài khoản
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $_base_url_employer;?>/thiet-lap">
                                    <span class="fa fa-cog"> </span>
                                    Thiết lập
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $_base_url_employer;?>/doi-mat-khau">
                                    <span class="fa fa-key"> </span>
                                    Đổi mật khẩu
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo $_base_url_employer;?>/dang-xuat">
                                    <span class="fa fa-power-off"></span>
                                    Đăng xuất
                                </a>
                            </li>
                        </ul>
                        <?php
                    }
                    ?>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</div>


