<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="/admin">Trang chủ</a>
                </li>
                <li><a href="/admin/members">Thành viên</a> </li>
                <li  class="active">Hồ sơ thành viên</li>
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
                    Hồ sơ thành viên
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        overview &amp; stats
                    </small>
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <?php
                    echo $this->Session->flash();
                    ?>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="row">
                                <div class="col-sm-12 recruitment-title">
                                    <h4 class="blue">
                                        <?php echo isset($members['Recruitment']['title'])? htmlentities($members['Recruitment']['title'], ENT_QUOTES, 'UTF-8'): '';?>
                                    </h4>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <div class="image">
                                        <?php
                                        $avatar = 'default_user.jpg';
                                        if($members['Member']['avatar'] != '' && file_exists(WWW_ROOT . '/img/members/' . $members['Member']['avatar']))
                                        {
                                            $avatar = $members['Member']['avatar'];
                                        }
                                        ?>
                                        <img class="img-circle" src="/img/members/<?php echo $avatar;?>" style="width: 150px; height: 150px">
                                    </div>
                                </div>
                                <div class="col-sm-8 general">
                                    <div class="bigger-150 orange2">
                                        <?php
                                        echo htmlentities($members['Member']['fullname'], ENT_QUOTES, 'UTF-8');
                                        ?>
                                    </div>
                                    <div>
                                        <?php
                                        if($members['Member']['title'])
                                        {
                                            echo htmlentities($members['Member']['title'], ENT_QUOTES, 'UTF-8');
                                        }
                                        ?>
                                    </div>
                                    <div>
                                        <?php
                                        if(isset($members['Member']['birthday']))
                                        {
                                            echo '<i class="fa fa-birthday-cake"> </i> ' . $this->Lib->convertDateTime_Mysql_to_Date($members['Member']['birthday']);
                                        }
                                        ?>
                                    </div>
                                    <div class="statistic">
                                <span>
                                    <i class="fa fa-eye"></i>
                                    Lượt xem: <?php echo number_format($sum_view_resume, 0, '', '.');?>
                                </span>
                                        <span>
                                    <i class="fa fa-download"></i>
                                    Lượt tải hồ sơ: <?php echo $members['Member']['count_download'];?>
                                </span>
                                        <span>
                                    <i class="fa fa-line-chart"></i>
                                    Hoàn thành: <?php echo $members['Member']['per_complete'] . '%';?>
                                </span>
                                    </div>
                                    <div class="contact">
                                        <table>
                                            <tr>
                                                <td colspan="2" class="bolder">
                                                    Thông tin liên hệ
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="center">
                                                    <i class="fa fa-envelope"></i>
                                                </td>
                                                <td>
                                                    Email
                                                </td>
                                                <td>
                                                    <?php echo isset($members['Member']['email'])? $members['Member']['email']: '';?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="center">
                                                    <i class="fa fa-phone"></i>
                                                </td>
                                                <td>
                                                    Điện thoại
                                                </td>
                                                <td>
                                                    <?php
                                                    if(isset($members['Member']['phonenumber']))
                                                    {
                                                        echo $members['Member']['phonenumber'];
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <i class="fa fa-map-marker"> </i>
                                                </td>
                                                <td>
                                                    Địa chỉ
                                                </td>
                                                <td>
                                                    <?php
                                                    if($members['Member']['address'])
                                                    {
                                                        echo htmlentities($members['Member']['address'], ENT_QUOTES, 'UTF-8');
                                                    }
                                                    if($members['Province']['provincename'])
                                                    {
                                                        echo ', ';
                                                        echo $members['Province']['provincename'];
                                                    }
                                                    ?>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <table class="table table-bordered table-hover table-resume">
                                <tr>
                                    <td>
                                        Bằng cấp cao nhất
                                    </td>
                                    <td>
                                        <?php
                                        if(isset($members_degrees[0]['Degree']['degree_name']))
                                        {
                                            echo '<i class="fa fa-graduation-cap"> </i> ';
                                            echo $members_degrees[0]['Degree']['degree_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Kinh nghiệm
                                    </td>
                                    <td>
                                        <?php echo $members['Member']['experience']? $members['Member']['experience'] . ' năm' : ''?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kỹ năng</td>
                                    <td>
                                        <?php
                                        if(isset($members_skills) && count($members_skills) > 0)
                                        {
                                            foreach ($members_skills as $item)
                                            {
                                                echo '- ' . $item['Skill']['skill_name'] . '</br>';
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Ngôn ngữ
                                    </td>
                                    <td>
                                        <?php
                                        if(isset($members_languages) && count($members_languages) > 0)
                                        {
                                            foreach ($members_languages as $item)
                                            {
                                                ?>
                                                <i class="fa fa-language"></i>
                                                <?php echo $item['Language']['language_name'];?> -
                                                <?php echo $item['LanguageLevel']['level_name'];?>
                                                <br>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Công việc gần đây
                                    </td>
                                    <td>
                                        <?php
                                        if(isset($works[0]['Work']['company_name']))
                                        {
                                            echo htmlentities($works[0]['Work']['title'], ENT_QUOTES, 'UTF-8') . ' - ';
                                            echo htmlentities($works[0]['Work']['company_name'], ENT_QUOTES, 'UTF-8');
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Cấp bậc mong muốn
                                    </td>
                                    <td>
                                        <?php
                                        if(isset($desires['Level']['levelname']))
                                        {
                                            echo $desires['Level']['levelname'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Công việc mong muốn
                                    </td>
                                    <td>
                                        <div class="job">
                                            <?php
                                            if(isset($desires_jobs) && count($desires_jobs) > 0)
                                            {
                                                $i = 0;
                                                foreach ($desires_jobs as $item)
                                                {
                                                    echo '<i class="fa fa-check"> </i> ' . $item['Job']['jobname'] . '<br>';
                                                    $desire_job_selected[$i] = $item['Job']['id'];
                                                    $i = $i + 1;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Nơi làm việc mong muốn
                                    </td>
                                    <td>
                                        <div class="province">
                                            <?php
                                            if(isset($desires_provinces) && count($desires_provinces) > 0)
                                            {
                                                $j = 0;
                                                foreach ($desires_provinces as $item)
                                                {
                                                    echo '<i class="fa fa-map-marker"> </i> ' . $item['Province']['provincename'] . '<br>';
                                                    $desire_province_selected[$j] = $item['Province']['id'];
                                                    $j = $j + 1;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Mức lương mong muốn
                                    </td>
                                    <td>
                                        <?php
                                        if(isset($desires['Desire']['salary']))
                                        {
                                            ?>
                                            <i class="fa fa-dollar"></i>
                                            <?php echo number_format($desires['Desire']['salary'], 0, '', '.');?>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            <?php
                            if(file_exists(WWW_ROOT . '/resume/' . $members['Member']['f_profile']))
                            {
                                ?>
                                <object data="/resume/<?php echo $members['Member']['f_profile'];?>" width="100%" height="500px" type='application/msword'>
                                    Trình duyệt không hỗ trợ
                                    <a href="">tải hồ sơ tại đây</a>
                                </object>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
