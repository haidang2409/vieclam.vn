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
    echo $this->Html->css('app_common');
    echo $this->Html->css('style');
    echo $this->Html->css('home_style');
    echo $this->Html->script('jquery-2.1.4.min', array());
    echo $this->Js->writeBuffer();
    ?>
    <meta property="og:url"  content="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php if(isset($title)){ echo $title;} else { echo $default_title;} echo ' - ' . $_SERVER['HTTP_HOST'];?>"/>
    <meta property="og:description" content="<?php echo isset($head_description)? $head_description: $default_description;?>"/>
    <meta property="og:image" content="<?php if(isset($og_image)) { echo $og_image;} else { echo $_SERVER['HTTP_HOST'] . '/img/og_logo_default.jpg';}?>"/>
    <meta itemprop="name" content="<?php if(isset($title)){ echo $title;} else { echo $default_title;} echo ' - ' . $_SERVER['HTTP_HOST'];?>"/>
    <meta itemprop="description" content="<?php echo isset($head_description)? $head_description: $default_description;?>"/>
    <meta itemprop="image" content="<?php if(isset($og_image)) { echo $og_image;} else { echo $_SERVER['HTTP_HOST'] . '/img/og_logo_default.jpg';}?>"/>
</head>
<body>
<?php
include ('analyticstracking.ctp');
?>
<div class="hero">
    <div class="">
        <nav style="z-index: 9" class="container navbar-custom nav-index navbar navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-xs" href="/">
                    <img src="/img/logo_primary.png" height="100px">
                </a>
                <a class="navbar-brand visible-xs" href="/">
                    <img src="/img/logo_primary_xs.png" height="43px" style="padding-top: 5px; padding-left: 20px">
                </a>
            </div>
            <div class="collapse collapse-index navbar-collapse js-navbar-collapse">
                <div class="container">
                    <!--Ul profile-->
                    <ul class="nav navbar-nav navbar-right navbar-right-custom">
                            <li>
                                <a href="/tim-viec-lam">TÌM VIỆC LÀM</a>
                            </li>
                            <li>
                                <a href="/nha-tuyen-dung">NHÀ TUYỂN DỤNG</a>
                            </li>
                            <?php
                            if($this->Session->check('S_Member'))
                            {
                                ?>
                                <li>
                                    <a href="/cap-nhat-ho-so">HỒ SƠ</a>
                                </li>
                                <li>
                                    <a href="/dang-xuat">ĐĂNG XUẤT</a>
                                </li>
                                <?php
                            }
                            else
                            {
                                ?>
                                <li>
                                    <a href="/dang-nhap">ĐĂNG NHẬP</a>
                                </li>
                                <li>
                                    <a href="/dang-ky">ĐĂNG KÝ</a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                </div>
            </div><!-- /.nav-collapse -->
        </nav>
    </div>
    <div class="container">
        <div class="div-search-index div-index-primary">
            <div class="row">
                <div class="col-sm-12 text-center title">
                    <h1 class="hidden-sm">TÌM KIẾM CÔNG VIỆC BẠN MONG MUỐN</h1>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="Từ khóa tìm kiếm" id="key_word">
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group has-feedback">
                            <?php
                            echo $this->Form->input('category_search', array('type' => 'select', 'label' => false, 'id' => 'category_search', 'options' => $jobs, 'empty' => '', 'style' => 'width: 100% !important'))
                            ?>
                            <span class="glyphicon  glyphicon-list form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group has-feedback">
                            <?php
                            echo $this->Form->input('province_search', array('type' => 'select', 'label' => false, 'id' => 'province_search', 'options' => $provinces, 'empty' => '', 'style' => 'width: 100% !important'))
                            ?>
                            <span class="glyphicon  glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-search-index"><i class="fa fa-search"></i> Tìm kiếm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



