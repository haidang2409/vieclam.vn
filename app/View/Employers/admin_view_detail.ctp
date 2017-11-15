<div class="main-content" id="content-employer">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="/admin">Trang chủ</a>
                </li>
                <li>
                    <a href="/admin/employers">Nhà tuyển dụng</a>
                </li>
                <li class="active">Thông tin nhà tuyển dụng</li>
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
        <!--            Search-->
        <!--        End form search-->
        <div class="page-content">
            <div class="page-header">
                <h1>
                    <?php
                    echo htmlentities($employers['Employer']['company_name'], ENT_QUOTES, 'UTF-8');
                    ?>
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 div-has-table">
                    <table class="table table-bordered">
                        <tr>
                            <td style="min-width: 150px">
                                Tên công ty
                            </td>
                            <td class="bolder">
                                <?php
                                echo htmlentities($employers['Employer']['company_name']);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Quy mô
                            </td>
                            <td>
                                <?php
                                echo htmlentities($employers['Scale']['scale_name']);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Liên hệ
                            </td>
                            <td>
                                <?php
                                echo '<i class="fa fa-envelope"> </i> ' . $employers['Employer']['email'];
                                echo '<br>';
                                echo '<i class="fa fa-phone"> </i> ' . $employers['Employer']['phone'];
                                echo '<br>';
                                echo '<i class="fa fa-building"> </i> ' . $employers['Employer']['address'];
                                echo ', ' . $employers['Province']['provincename'];
                                echo '<br>';
                                echo '<i class="fa fa-user"> </i> ' . $employers['Employer']['fullname'];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Sơ lược công ty
                            </td>
                            <td>
                                <?php
                                echo nl2br(htmlentities($employers['Employer']['description'], ENT_QUOTES, 'UTF-8'));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Lĩnh vực hoạt động
                            </td>
                            <td>
                                <?php
                                if(isset($employers_jobs) && count($employers_jobs) > 0)
                                {
                                    foreach ($employers_jobs as $ej)
                                    {
                                        echo '<i class="fa fa-folder-open"></i> ' . $ej['Job']['jobname'] . '<br>';
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Phúc lợi công ty
                            </td>
                            <td>
                                <?php
                                if(isset($employers_benefits) && count($employers_benefits) > 0)
                                {
                                    foreach ($employers_benefits as $eb)
                                    {
                                        echo '<i class="' . $eb['Benefit']['icon'] . '"></i> ' . $eb['EmployerBenefit']['note'] . '<br>';
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Logo
                            </td>
                            <td class="text-center">
                                <?php
                                if($employers['Employer']['logo'] != '' && file_exists(WWW_ROOT . '/uploads/company/' . $employers['Employer']['logo']))
                                {
                                    ?>
                                    <img src="/uploads/company/<?php echo $employers['Employer']['logo'];?>" style="width: 200px">
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Website
                            </td>
                            <td>
                                <?php
                                if($employers['Employer']['website'])
                                {
                                    echo '<a href="' . $employers['Employer']['website'] . '">' . $employers['Employer']['website'] . '</a>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Video
                            </td>
                            <td>
                                <?php
                                echo $employers['Employer']['video'];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Ngày tham gia
                            </td>
                            <td>
                                <?php
                                echo $this->Lib->convertDateTime_Mysql_To_DateTime($employers['Employer']['created']);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Ngày cập nhật
                            </td>
                            <td>
                                <?php
                                echo $this->Lib->convertDateTime_Mysql_To_DateTime($employers['Employer']['updated']);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Hoạt động lần cuối
                            </td>
                            <td>
                                <?php
                                echo $this->Lib->convertDateTime_Mysql_To_DateTime($employers['Employer']['last_login']);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Trạng thái
                            </td>
                            <td>
                                <?php
                                if($employers['Employer']['status'] == 1)
                                {
                                    echo 'Đang hoạt động';
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
                                Xác thực email
                            </td>
                            <td>
                                <?php
                                if($employers['Employer']['is_active_email'] == 1)
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
                                Tin đã đăng
                            </td>
                            <td>
                                <a href="/admin/recruitments?employerId=<?php echo $employers['Employer']['id'];?>">
                                    <?php echo $count_recruitment;?>
                                    việc <làm></làm>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<!--End modal-->
<script>
    $(function () {
        $('#li-employer').addClass('active open');
        $('#li-list-employer').addClass('active');

    });
</script>