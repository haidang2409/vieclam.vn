<?php
if(isset($recruitments))
{
    ?>
    <nav class="nav-detail navbar navbar-default navbar-fixed-top " role="navigation">
        <div class="container recruitment-header-scroll">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="row">
                <div class="col-sm-8 hidden-xs">
                    <h4>
                        <?php
                        echo $recruitments['Recruitment']['title'];
                        ?>
                    </h4>
                </div>
                <div class="col-sm-4 text-right text-center-xs">
                    <?php
                    if(isset($save_or_applied_recruitments) && count($save_or_applied_recruitments) > 0)
                    {
                        if($save_or_applied_recruitments['MemberRecruitment']['is_applied'] == 1)
                        {
                            ?>
                            <button class="btn btn-success btn-apply-recruitment" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"> <i class="fa fa-check"> </i> Đã nộp đơn</button>
                            <button class="btn btn-success btn-save-recruitment-detail" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"> <i class="fa fa-heart"> </i> Đã lưu</button>
                            <?php
                        }
                        else
                        {
                            ?>
                            <button class="btn btn-warning btn-apply-recruitment" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"> <i class="fa fa-check"> </i> Nộp đơn</button>
                            <button class="btn btn-success btn-save-recruitment-detail" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"> <i class="fa fa-heart"> </i> Đã lưu</button>
                            <?php
                        }

                    }
                    else
                    {
                        ?>
                        <button class="btn btn-warning btn-apply-recruitment" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"><i class="fa fa-plus"> </i> Nộp đơn</button>
                        <button class="btn btn-warning btn-save-recruitment-detail" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"><i class="fa fa-heart-o"> </i> Lưu</button>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
        </div><!-- /.container-fluid -->
    </nav>
    <?php
}
?>
<div class="background-primary">
    <div class="container">
        <div class="row">
            <?php
            if(isset($recruitments))
            {
                ?>
                <div class="col-md-9 recruitment-detail">
                    <div class="search-item-clear"></div>
                        <div class="background-white background-padding">
                            <div class="title">
                                <h1>
                                    <?php echo htmlentities($recruitments['Recruitment']['title'], ENT_QUOTES, 'UTF-8');?>
                                </h1>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="widget-box transparent" id="recent-box">
                                                <div class="widget-header">
                                                    <h4 class="widget-title lighter smaller red hidden-xs">
                                                        <i class="ace-icon fa fa-dollar"></i>
                                                        <?php
                                                        if($recruitments['Recruitment']['hide_salary'] == 1)
                                                        {
                                                            echo 'Lương thỏa thuận';
                                                        }
                                                        else
                                                        {
                                                            echo number_format($recruitments['Recruitment']['salary_min'], 0, '', '.');
                                                            echo ' - ';
                                                            echo number_format($recruitments['Recruitment']['salary_max'], 0, '', '.');
                                                        }
                                                        ?>
                                                    </h4>
                                                    <div class="widget-toolbar no-border">
                                                        <ul class="nav nav-tabs" id="recent-tab">
                                                            <li class="active">
                                                                <a data-toggle="tab" href="#task-tab" aria-expanded="true">VIỆC LÀM</a>
                                                            </li>

                                                            <li class="">
                                                                <a data-toggle="tab" href="#member-tab" aria-expanded="false">VỀ CÔNG TY</a>
                                                            </li>

<!--                                                            <li class="">-->
<!--                                                                <a data-toggle="tab" href="#comment-tab" aria-expanded="false">Comments</a>-->
<!--                                                            </li>-->
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="widget-body">
                                                    <div class="widget-main padding-4">
                                                        <div class="tab-content padding-0">
                                                            <div id="task-tab" class="tab-pane active">
                                                                <div class="visible-xs salary text-center" style="padding-top: 10px">
                                                                    <i class="ace-icon fa fa-dollar"></i>
                                                                    <?php
                                                                    if($recruitments['Recruitment']['hide_salary'] == 1)
                                                                    {
                                                                        echo 'Lương thỏa thuận';
                                                                    }
                                                                    else
                                                                    {
                                                                        echo number_format($recruitments['Recruitment']['salary_min'], 0, '', '.');
                                                                        echo ' - ';
                                                                        echo number_format($recruitments['Recruitment']['salary_max'], 0, '', '.');
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <h3>MÔ TẢ CÔNG VIỆC</h3>
                                                                <div class="description" id="description">
                                                                    <?php
                                                                    echo nl2br(htmlentities($recruitments['Recruitment']['description'], ENT_QUOTES, 'UTF-8'));
                                                                    ?>
                                                                </div>
                                                                <h3>YÊU CẦU CÔNG VIỆC</h3>
                                                                <div class="description" id="require">
                                                                    <?php
                                                                    echo nl2br(htmlentities($recruitments['Recruitment']['require'], ENT_QUOTES, 'UTF-8'));
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div id="member-tab" class="tab-pane">
                                                                <h3>VỀ CÔNG TY</h3>
                                                                <div class="description">
                                                                    <?php
                                                                    echo nl2br(htmlentities($recruitments['Employer']['description'], ENT_QUOTES, 'UTF-8'));
                                                                    ?>
                                                                </div>
                                                                <hr class="dotted">
                                                                <?php
                                                                if($recruitments['Employer']['website'])
                                                                {
                                                                    ?>
                                                                    <span class="contact">
                                                                        <i class="fa fa-globe"></i>
                                                                        <a href="<?php echo $recruitments['Employer']['website'];?>"><?php echo $recruitments['Employer']['website'];?></a>
                                                                    </span>
                                                                    <?php
                                                                }
                                                                if($recruitments['Employer']['fullname'])
                                                                {
                                                                    ?>
                                                                    <span class="contact">
                                                                        <i class="fa fa-user"></i>
                                                                        <?php echo $recruitments['Employer']['fullname'];?>
                                                                    </span>
                                                                    <?php
                                                                }
                                                                if($recruitments['Employer']['email'])
                                                                {
                                                                    ?>
                                                                    <span class="contact">
                                                                        <i class="fa fa-envelope"></i>
                                                                        <?php echo $recruitments['Employer']['email'];?>
                                                                    </span>
                                                                    <?php
                                                                }
                                                                if($recruitments['Employer']['phone'])
                                                                {
                                                                    ?>
                                                                    <span class="contact">
                                                                        <i class="fa fa-phone"></i>
                                                                        <?php echo $recruitments['Employer']['phone'];?>
                                                                    </span>
                                                                    <?php
                                                                }
                                                                if($recruitments['Employer']['address'])
                                                                {
                                                                    ?>
                                                                    <span class="contact">
                                                                        <i class="fa fa-building"></i>
                                                                        <?php echo $recruitments['Employer']['address'];?>
                                                                    </span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div><!-- /.#member-tab -->

<!--                                                            <div id="comment-tab" class="tab-pane">-->
<!---->
<!--                                                            </div>-->
                                                        </div>
                                                    </div><!-- /.widget-main -->
                                                </div><!-- /.widget-body -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 image text-center">
                                    <hr class="dotted visible-xs">
                                    <?php
                                    if(isset($save_or_applied_recruitments) && count($save_or_applied_recruitments) > 0)
                                    {
                                        if($save_or_applied_recruitments['MemberRecruitment']['is_applied'] == 1)
                                        {
                                            ?>
                                            <button class="btn btn-success btn-apply-recruitment" style="width: 40%" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"> <i class="fa fa-check"> </i> Đã nộp đơn</button>
                                            <button class="btn btn-success btn-save-recruitment-detail" style="width: 40%" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"> <i class="fa fa-heart"> </i> Đã lưu</button>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <button class="btn btn-warning btn-apply-recruitment" style="width: 40%" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"> <i class="fa fa-check"> </i> Nộp đơn</button>
                                            <button class="btn btn-success btn-save-recruitment-detail" style="width: 40%" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"> <i class="fa fa-heart"> </i> Đã lưu</button>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                        <button class="btn btn-warning btn-apply-recruitment" style="width: 40%" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"><i class="fa fa-plus"> </i> Nộp đơn</button>
                                        <button class="btn btn-warning btn-save-recruitment-detail" style="width: 40%" data-recruitment_id="<?php echo $recruitments['Recruitment']['id'];?>"><i class="fa fa-heart-o"> </i> Lưu</button>
                                        <?php
                                    }
                                    ?>
                                    <br>
                                    <a href="javascript: void(0)">
                                        <img src="/uploads/company/<?php echo $recruitments['Employer']['logo']?>">
                                    </a>
                                    <div class="company-name">
                                        <?php
                                        echo $recruitments['Employer']['company_name'];
                                        ?>
                                    </div>
                                    <div class="">
                                        <div class="date">
                                            <div class="row">
                                                <div class="col-xs-3 text-right icon">
                                                    <i class="fa fa-eye"></i>
                                                </div>
                                                <div class="col-xs-9 text text-left">
                                                    Lượt xem
                                                    <br>
                                                    <b>
                                                        <?php echo ($recruitments['Recruitment']['view'] + 1) . ' lượt xem';?>
                                                    </b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="date">
                                            <div class="row">
                                                <div class="col-xs-3 text-right icon">
                                                    <i class="fa fa-calendar-check-o"></i>
                                                </div>
                                                <div class="col-xs-9 text text-left">
                                                    Ngày đăng tuyển
                                                    <br>
                                                    <b>
                                                        <?php echo $this->Lib->convertDateTime_Mysql_to_Date($recruitments['Order']['created']);?>
                                                    </b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="date">
                                            <div class="row">
                                                <div class="col-xs-3 text-right icon">
                                                    <i class="fa fa-briefcase"></i>
                                                </div>
                                                <div class="col-xs-9 text text-left">
                                                    Cấp bậc
                                                    <br>
                                                    <b>
                                                        <?php echo $recruitments['Level']['levelname'];?>
                                                    </b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="date">
                                            <div class="row">
                                                <div class="col-xs-3 text-right icon">
                                                    <i class="fa fa-language"></i>
                                                </div>
                                                <div class="col-xs-9 text text-left">
                                                    Ngôn ngữ hồ sơ
                                                    <br>
                                                    <b>
                                                        <?php echo $recruitments['RecruitmentLanguage']['recruitment_language_name'];?>
                                                    </b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="date">
                                            <div class="row">
                                                <div class="col-xs-3 text-right icon">
                                                    <i class="fa fa-graduation-cap"></i>
                                                </div>
                                                <div class="col-xs-9 text text-left">
                                                    Ngành tuyển dụng
                                                    <br>
                                                    <b>
                                                        <?php
                                                        if(count($recruitments['RecruitmentJob']) > 0)
                                                        {
                                                            $count_job = count($recruitments['RecruitmentJob']);
                                                            for($i = 0; $i < $count_job; $i++)
                                                            {
                                                                $rp = $recruitments['RecruitmentJob'][$i];
                                                                echo $rp['Job']['jobname'];
                                                                if($i < $count_job - 1)
                                                                {
                                                                    echo ', ';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="date">
                                            <div class="row">
                                                <div class="col-xs-3 text-right icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                                <div class="col-xs-9 text text-left">
                                                    Nơi làm việc
                                                    <br>
                                                    <b>
                                                        <?php
                                                        if(count($recruitments['RecruitmentProvince']) > 0)
                                                        {
                                                            $count_province = count($recruitments['RecruitmentProvince']);
                                                            for($i = 0; $i < $count_province; $i++)
                                                            {
                                                                $rp = $recruitments['RecruitmentProvince'][$i];
                                                                echo $rp['Province']['provincename'];
                                                                if($i < $count_province - 1)
                                                                {
                                                                    echo ', ';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </b>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        //Quy mô công ty
                                        if($recruitments['Scale']['scale_name'])
                                        {
                                            ?>
                                            <div class="date">
                                                <div class="row">
                                                    <div class="col-xs-3 text-right icon">
                                                        <i class="fa fa-users"></i>
                                                    </div>
                                                    <div class="col-xs-9 text text-left">
                                                        Quy mô công ty
                                                        <br>
                                                        <b>
                                                            <?php
                                                            echo $recruitments['Scale']['scale_name'] . ' nhân viên';
                                                            ?>
                                                        </b>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="benefit-container text-left">
                                        <?php
                                        if(isset($benefits) && count($benefits) > 0)
                                        {
                                            ?>
                                            <div class="benefit-container-header">
                                                <h3>
                                                    PHÚC LỢI CHO BẠN
                                                </h3>
                                            </div>
                                            <?php
                                            foreach ($benefits as $b)
                                            {
                                                ?>
                                                <div class="item">
                                                    <i class="<?php echo $b['Benefit']['icon']?>"></i>
                                                    <?php echo $b['EmployerBenefit']['note'];?>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="search-item-clear"></div>
                </div>
                <div class="col-md-3">
                    <div class="search-item-clear"></div>
                    <div class="background-white">
                        <div class="container-re-relative">
                            <div class="container-header">
                                <h3>CÔNG VIỆC LIÊN QUAN</h3>
                            </div>
                            <?php
                            if(isset($recruitments_relative) && count($recruitments_relative) > 0)
                            {
                                foreach ($recruitments_relative as $item)
                                {
                                    ?>
                                    <div class="item">
                                        <div class="row">
                                            <div class="col-xs-3 image">
                                                <a href="/tim-viec-lam/<?php echo $item['Recruitment']['link'];?>/<?php echo $item['Recruitment']['id'];?>" title="<?php echo $item['Recruitment']['title'];?>">
                                                    <img src="/uploads/company/<?php echo $item['Employer']['logo'];?>">
                                                </a>
                                            </div>
                                            <div class="col-xs-9 content">
                                                <a href="/tim-viec-lam/<?php echo $item['Recruitment']['link'];?>/<?php echo $item['Recruitment']['id'];?>" title="<?php echo $item['Recruitment']['title'];?>">
                                                    <h3>
                                                        <?php echo htmlentities($item['Recruitment']['title'], ENT_QUOTES, 'UTF-8');?>
                                                    </h3>
                                                </a>
                                                <span class="company-name">
                                                <?php echo htmlentities($item['Employer']['company_name'], ENT_QUOTES, 'UTF-8');?>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="search-item-clear"></div>
                </div>
                <?php
            }
            else
            {
                echo $this->element('error');
            }
            ?>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(".nav-detail").hide();
        $(window).scroll(function () {
            if ($(this).scrollTop() > 200) {
                $('.nav-detail').fadeIn();
            } else {
                $('.nav-detail').fadeOut();
            }
        });
    })
</script>