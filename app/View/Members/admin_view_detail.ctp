<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="/admin">Trang chủ</a>
                </li>
                <li><a href="/admin/members">Thành viên</a> </li>
                <li  class="active">Thông tin thành viên</li>
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
                <h1>
                    Thông tin thành viên
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        overview &amp; stats
                    </small>
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    echo $this->Session->flash();
                    ?>
                    <table class="table table-hover table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                    Họ tên
                                </td>
                                <td>
                                    <?php echo htmlentities($members['Member']['fullname'], ENT_QUOTES, 'UTF-8');?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email
                                </td>
                                <td>
                                    <?php
                                    echo $members['Member']['email'];
                                    if($members['Member']['is_active_email'] == 1)
                                    {
                                        echo ' <font color="blue"> <i class="fa fa-check-circle-o"></i> </font> Đã xác thực';
                                    }
                                    else
                                    {
                                        echo ' <font color="#ff4500"> <i class="fa fa-info-circle"> </i> </font> Chưa xác thực';
                                        echo '<br><a href="javascript: void(0)" id="btnSendEmailVerify">Gửi lại email xác thực</a>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Giới tính
                                </td>
                                <td>
                                    <?php
                                    if($members['Member']['gender'] == '1')
                                    {
                                        echo 'Nam';
                                    }
                                    else if($members['Member']['gender'] == '0')
                                    {
                                        echo 'Nữ';
                                    }
                                    else
                                    {
                                        echo '_';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Ngày sinh</td>
                                <td>
                                    <?php echo $members['Member']['birthday'] != '0000-00-00'? $this->Lib->convertDateTime_Mysql_to_Date($members['Member']['birthday']): '_';?>
                                </td>
                            </tr>
                            <tr>
                                <td>Số điện thoại</td>
                                <td>
                                    <?php echo $members['Member']['phonenumber'];?>
                                </td>
                            </tr>
                            <tr>
                                <td>Địa chỉ</td>
                                <td>
                                    <?php echo htmlentities($members['Member']['address'], ENT_QUOTES, 'UTF-8');?>
                                    <?php echo $members['Province']['provincename'];?>
                                </td>
                            </tr>
                            <tr>
                                <td>Ngày đăng ký</td>
                                <td>
                                    <?php echo $this->Lib->convertDateTime_Mysql_to_DateTime($members['Member']['created']);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Ngày cập nhật</td>
                                <td>
                                    <?php echo $this->Lib->convertDateTime_Mysql_to_DateTime($members['Member']['updated']);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Hoạt động lần cuối</td>
                                <td>
                                    <?php echo $this->Lib->convertDateTime_Mysql_to_DateTime($members['Member']['lastlogin']);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Đang kích hoạt</td>
                                <td>
                                    <?php
                                    if($members['Member']['status'] == 1)
                                    {
                                        echo 'Đang kích hoạt';
                                    }
                                    else
                                    {
                                        echo 'Đã khóa';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Hồ sơ
                                </td>
                                <td>
                                    <a class="bolder" href="/admin/members/view_resume/<?php echo $members['Member']['id'];?>">
                                        Xem hồ sơ
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
