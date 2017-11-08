<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="#">Trang chủ</a>
                </li>
                <li><a href="/admin/posts">Bài viết</a> </li>
                <li>Chi tiết bài viết</li>
            </ul><!-- /.breadcrumb -->
            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon">
                        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div><!-- /.nav-search -->
        </div>
        <div class="page-content">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-10">
                        <h1>
                            <?php
                            echo $posts['Post']['title'];
                            ?>
                            <br>
                            <small>
                                <i class="ace-icon fa fa-angle-double-right"></i>
                                <?php
                                echo $posts['PostCategory']['name']
                                ?>
                                <br>
                                <i class="fa fa-user">
                                </i>
                                <?php
                                echo $posts['Staff']['fullname']
                                ?>
                            </small>
                        </h1>
                    </div>
                    <div class="col-sm-2 text-right">
                        <a href="/admin/posts/edit/<?php echo $posts['Post']['id'];?>" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i> Sửa
                        </a>
                    </div>
                </div>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-12">
                    <?php echo $this->Session->flash();?>
                    <div style="font-weight: bold">
                        <?php
                        echo $posts['Post']['summary'];
                        ?>
                    </div>
                    <?php
                    echo $posts['Post']['description'];
                    ?>
                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<script>
    $(function () {
        $('#li-post').addClass('active open');
    })
</script>
