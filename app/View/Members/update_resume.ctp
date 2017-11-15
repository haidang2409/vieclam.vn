<div class="background-primary">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="search-item-clear"></div>
                <div class="container_update_resume">
                    <div class="background-white background-padding general">
                        <div class="header-update">
                            <h4>
                                CẬP NHẬT HỒ SƠ
                            </h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                echo $this->Session->flash();
                                ?>
                            </div>
                            <div class="col-sm-3 image text-center">
                                <?php
                                $avatar = 'default_user.jpg';
                                if($members['Member']['avatar'])
                                {
                                    $avatar = $members['Member']['avatar'];
                                }
                                ?>
                                <div class="avatar-resume">
                                    <img class="img-circle" src="/img/members/<?php echo $avatar;?>">
                                    <div class="middle">
                                        <a href="javascript: void(0)" data-toggle="modal" data-target="#modalAvatar">
                                            Thay đổi ảnh
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <span class="orange2 bigger-150 bolder">
                                    <?php echo htmlentities($members['Member']['fullname'], ENT_QUOTES, 'UTF-8');?>
                                </span><br>
                                <span class="bolder">
                                    <?php
                                    if($members['Level']['levelname'])
                                    {
                                        echo $members['Level']['levelname'];
                                    }
                                    if($members['Member']['title'])
                                    {
                                        echo ' / ' . htmlentities($members['Member']['title'], ENT_QUOTES, 'UTF-8');
                                    }
                                    ?>
                                </span><br>
                                <span>
                                    Kinh nghiệm: <?php echo $members['Member']['experience']? $members['Member']['experience'] : ''?>
                                </span><br>
                                <span>
                                    Bằng cấp:
                                    <?php
                                    if(isset($members_degrees[0]['Degree']['degree_name']))
                                    {
                                        echo $members_degrees[0]['Degree']['degree_name'];
                                    }
                                    ?>
                                </span><br>
                                <span>
                                    Công ty:
                                    <?php
                                    if(isset($works[0]['Work']['company_name']))
                                    {
                                        echo htmlentities($works[0]['Work']['company_name'], ENT_QUOTES, 'UTF-8');
                                    }
                                    ?>
                                </span>

                            </div>
                            <div class="col-sm-1 text-right">
                                <button class="pencil-edit-resume" data-toggle="modal" data-target="#modalGeneral">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="search-item-clear"></div>
                    <div class="background-white background-padding summary">
                        <div class="header-update">
                            <h4>MỤC TIÊU NGHỀ NGHIỆP</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <?php
                                if($members['Member']['introduce'])
                                {
                                    echo nl2br(htmlentities($members['Member']['introduce'], ENT_QUOTES, 'UTF-8'));
                                }
                                else
                                {
                                    echo 'Giới thiệu sơ lược về bản thân...';
                                }
                                ?>
                            </div>
                            <div class="col-sm-1 text-right">
                                <button class="pencil-edit-resume" data-toggle="modal" data-target="#modalSummary">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="search-item-clear"></div>
                    <div class="background-white background-padding skill">
                        <div class="header-update">
                            <h4>KỸ NĂNG</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <?php
                                $skill_selected = array();
                                if(isset($members_skills) && count($members_skills) > 0)
                                {
                                    $i = 0;
                                    foreach ($members_skills as $item)
                                    {
                                        $skill_selected[$i] = $item['Skill']['id'];
                                        $i = $i + 1;
                                        echo '<span class="span-skill">' . $item['Skill']['skill_name'] . '</span>';
                                    }
                                }
                                else
                                {
                                    echo 'Bổ sung các kỹ năng bạn có vào hồ sơ';
                                }
                                ?>
                            </div>
                            <div class="col-sm-1 text-right">
                                <button class="pencil-edit-resume" data-toggle="modal" data-target="#modalSkill">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="search-item-clear"></div>
                    <div class="background-white background-padding language">
                        <div class="header-update">
                            <div class="row">
                                <div class="col-xs-10">
                                    <h4>TRÌNH ĐỘ NGOẠI NGỮ</h4>
                                </div>
                                <div class="col-xs-2 text-right bigger-140 has-icon">
                                    <a data-toggle="modal" data-target="#modalAddLanguage" href="" class="icon-add">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 row-language">
                                <?php
                                if(isset($members_languages) && count($members_languages) > 0)
                                {
                                    ?>
                                    <div class="row">
                                        <div class="col-xs-4 bolder">
                                            Ngoại ngữ
                                        </div>
                                        <div class="col-xs-4 bolder">
                                            Trình độ
                                        </div>
                                        <div class="col-xs-4">

                                        </div>
                                    </div>
                                    <?php
                                    foreach ($members_languages as $item)
                                    {
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <?php echo $item['Language']['language_name'];?>
                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo $item['LanguageLevel']['level_name'];?>
                                            </div>
                                            <div class="col-xs-4 text-right">
                                                <button class="trash-delete-resume delete-language" data-id="<?php echo $item['MemberLanguage']['id'];?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button class="pencil-edit-resume edit-language" data-language="<?php echo $item['Language']['id'];?>" data-language_level="<?php echo $item['LanguageLevel']['id'];?>" data-id="<?php echo $item['MemberLanguage']['id'];?>">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo 'Thêm ngôn ngữ vào hồ sơ của bạn';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="search-item-clear"></div>
                    <div class="background-white background-padding works">
                        <div class="header-update">
                            <div class="row">
                                <div class="col-xs-10">
                                    <h4>QUÁ TRÌNH LÀM VIỆC</h4>
                                </div>
                                <div class="col-xs-2 text-right bigger-140 has-icon">
                                    <a data-toggle="modal" data-target="#modalAddWork" href="" class="icon-add">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 row-work">
                                <?php
                                if(isset($works) && count($works) > 0)
                                {
                                    foreach ($works as $item)
                                    {
                                        ?>
                                        <div class="row item">
                                            <div class="col-xs-10">
                                                <div class="bolder title">
                                                    <?php echo htmlentities($item['Work']['title'], ENT_QUOTES, 'UTF-8');?>
                                                </div>
                                                <div class="company_name">
                                                    <?php echo htmlentities($item['Work']['company_name'], ENT_QUOTES, 'UTF-8');?>
                                                </div>
                                                <div class="time">
                                                    <?php
                                                    echo 'Từ ' . $item['Work']['from'];
                                                    if($item['Work']['is_now'] == 1)
                                                    {
                                                        echo ' đến hiện tại';
                                                    }
                                                    else
                                                    {
                                                        echo ' đến ' . $item['Work']['to'];
                                                    }
                                                    ?>

                                                </div>
                                                <div class="summary">
                                                    <?php
                                                    if($item['Work']['summary'])
                                                    {
                                                        echo htmlentities($item['Work']['summary'], ENT_QUOTES, 'UTF-8');
                                                    }
                                                    else
                                                    {
                                                        echo '<span style="color: #cccccc">Mô tả công việc bạn làm tại công ty</span>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 text-right">
                                                <button class="trash-delete-resume delete-work" data-id="<?php echo $item['Work']['id'];?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button class="pencil-edit-resume edit-work" data-id="<?php echo $item['Work']['id'];?>" data-company_name="<?php echo $item['Work']['company_name'];?>" data-title="<?php echo $item['Work']['title'];?>" data-from="<?php echo $item['Work']['from'];?>" data-to="<?php echo $item['Work']['to'];?>" data-is_now="<?php echo $item['Work']['is_now'];?>" data-summary="<?php echo htmlentities($item['Work']['summary'], ENT_QUOTES, 'UTF-8');?>">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo 'Thêm quá trình và kinh nghiệm làm việc vào hồ sơ của bạn';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="search-item-clear"></div>
                    <div class="background-white background-padding degrees">
                        <div class="header-update">
                            <div class="row">
                                <div class="col-xs-10">
                                    <h4>HỌC VẤN VÀ BẰNG CẤP</h4>
                                </div>
                                <div class="col-xs-2 text-right bigger-140 has-icon">
                                    <a data-toggle="modal" data-target="#modalAddDegree" href="" class="icon-add">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 row-degree">
                                <?php
                                if(isset($members_degrees) && count($members_degrees) > 0)
                                {
                                    foreach ($members_degrees as $item)
                                    {
                                        ?>
                                        <div class="row item">
                                            <div class="col-xs-10">
                                                <div class="bolder job">
                                                    <?php echo htmlentities($item['MemberDegree']['specialized'], ENT_QUOTES, 'UTF-8');?>
                                                </div>
                                                <div class="degree_level">
                                                    <?php echo $item['Degree']['degree_name'];?>
                                                </div>
                                                <div class="school">
                                                    <?php echo htmlentities($item['MemberDegree']['school'], ENT_QUOTES, 'UTF-8');?>
                                                </div>
                                                <div class="time">
                                                    <?php
                                                    echo 'Từ ' . $item['MemberDegree']['from'] . ' đến ' . $item['MemberDegree']['to'];
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="col-xs-2 text-right">
                                                <button class="trash-delete-resume delete-degree" data-id="<?php echo $item['MemberDegree']['id'];?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button class="pencil-edit-resume edit-degree" data-id="<?php echo $item['MemberDegree']['id'];?>" data-specialized="<?php echo htmlentities($item['MemberDegree']['specialized'], ENT_QUOTES, 'UTF-8');?>" data-school="<?php echo htmlentities($item['MemberDegree']['school'], ENT_QUOTES, 'UTF-8');?>" data-degree="<?php echo $item['MemberDegree']['degree_id'];?>" data-from="<?php echo $item['MemberDegree']['from'];?>" data-to="<?php echo $item['MemberDegree']['to'];?>">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo 'Thêm học vấn và bằng cấp vào hồ sơ của bạn';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="search-item-clear"></div>
                    <div class="background-white background-padding refers">
                        <div class="header-update">
                            <div class="row">
                                <div class="col-xs-10">
                                    <h4>THÔNG TIN THAM KHẢO</h4>
                                </div>
                                <div class="col-xs-2 text-right bigger-140 has-icon">
                                    <a data-toggle="modal" data-target="#modalAddRefer" href="" class="icon-add">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 row-refer">
                                <?php
                                if(isset($refers) && count($refers) > 0)
                                {
                                    foreach ($refers as $item)
                                    {
                                        ?>
                                        <div class="row item">
                                            <div class="col-xs-10">
                                                <div class="bolder fillname">
                                                    <?php echo htmlentities($item['Refer']['fullname'], ENT_QUOTES, 'UTF-8');?>
                                                </div>
                                                <div class="title">
                                                    <?php echo htmlentities($item['Refer']['title'], ENT_QUOTES, 'UTF-8');?>
                                                </div>
                                                <div class="company">
                                                    <?php echo htmlentities($item['Refer']['company'], ENT_QUOTES, 'UTF-8');?>
                                                </div>
                                                <div class="contanct">
                                                    <?php echo $item['Refer']['phone'] . ' - ' . $item['Refer']['email'];?>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 text-right">
                                                <button class="trash-delete-resume delete-refer" data-id="<?php echo $item['Refer']['id'];?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button class="pencil-edit-resume edit-refer" data-id="<?php echo $item['Refer']['id'];?>"
                                                        data-title="<?php echo htmlentities($item['Refer']['title'], ENT_QUOTES, 'UTF-8');?>"
                                                        data-fullname="<?php echo htmlentities($item['Refer']['fullname'], ENT_QUOTES, 'UTF-8');?>"
                                                        data-company="<?php echo htmlentities($item['Refer']['company'], ENT_QUOTES, 'UTF-8');?>"
                                                        data-phone="<?php echo $item['Refer']['phone'];?>"
                                                        data-email="<?php echo $item['Refer']['email'];?>">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo 'Thêm thông tin tham khảo về công ty bạn từng làm';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="search-item-clear"></div>
                    <div class="background-white background-padding desires">
                        <div class="header-update">
                            <div class="row">
                                <div class="col-xs-10">
                                    <h4>CÔNG VIỆC MONG MUỐN</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 row-desire">
                                <?php
                                $desire_level_id = '';
                                $desire_salary = '';
                                $desire_job_selected = null;
                                $desire_province_selected = null;
                                $desire_benefit_selected = null;
                                if(isset($desires) && count($desires) > 0)
                                {
                                    $desire_level_id = $desires['Desire']['level_id'];
                                    $desire_salary = $desires['Desire']['salary'] != ''? number_format($desires['Desire']['salary'], 0, '', ','): '';
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-6 job">
                                            <span class="bolder">Công việc mong muốn</span>
                                            <br>
                                            <div class="content">
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
                                        </div>
                                        <div class="col-sm-6 province">
                                            <span class="bolder">Nơi làm việc mong muốn</span>
                                            <br>
                                            <div class="content">
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
                                        </div>
                                        <div class="col-sm-6 level">
                                            <span class="bolder">Cấp bậc mong muốn</span>
                                            <br>
                                            <div class="content">
                                                <?php
                                                echo $desires['Level']['levelname'];
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 salary">
                                            <span class="bolder">Mức lương mong muốn</span>
                                            <br>
                                            <div class="content">
                                                <?php
                                                echo '<i class="fa fa-dollar"> </i> ' . number_format($desires['Desire']['salary'], 0, '', '.');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 benefit">
                                            <span class="bolder">Phúc lợi mong muốn</span>
                                            <br>
                                            <div class="content">
                                                <?php
                                                if(isset($desires_benefits) && count($desires_benefits) > 0)
                                                {
                                                    $l = 0;
                                                    foreach ($desires_benefits as $item)
                                                    {
                                                        echo '<i class="' . $item['Benefit']['icon'] . '"> </i> ' . $item['Benefit']['benefit_name'] . '<br>';
                                                        $desire_benefit_selected[$l] = $item['Benefit']['id'];
                                                        $l = $l + 1;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    echo '<b>Nhà tuyển dụng chưa tìm thấy được hồ sơ của bạn</b><br>';
                                    echo 'Thêm thông ngành nghề, nơi làm việc, mức lương... bạn mong muốn';
                                }
                                ?>
                            </div>
                            <div class="col-sm-2 text-right">
                                <button class="pencil-edit-resume" data-toggle="modal" data-target="#modalEditDesire">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search-item-clear"></div>
            </div>
            <div class="col-sm-3">
                <div class="search-item-clear"></div>
                <div class="warning-resum background-white background-padding">
                    <div class="resume-status-header">
                        <h4>TÌNH TRẠNG HỒ SƠ</h4>
                    </div>
                    <?php
                    if(count($desires) <= 0)
                    {
                        ?>
                        <span class="text-danger bigger-120">
                            <i class="fa fa-warning"></i>
                            Nhà tuyển dụng chưa tìm thấy được hồ sơ của bạn
                            vui lòng cập nhật công việc mong muốn của bạn
                        </span>
                        <div class="div-btn-update-desire">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditDesire">
                                <i class="fa fa-pencil"></i>
                                Cập nhật
                            </button>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="circle-percent-container">
                        <?php
                        $per_complete = $members['Member']['per_complete'];
                        if($per_complete == 100)
                        {
                            echo '<span class="green bolder">Chúc mừng!<br> Hồ sơ của bạn đã hoàn thành</span>';
                        }
                        else if($per_complete < 100 && $per_complete >= 60)
                        {
                            echo 'Mức độ hoàn thành <span class="green bolder">' . $per_complete . '%</span>';
                            echo '<br><a href="javascript: void(0)" class="popover-warning" data-rel="popover" data-placement="bottom" title="" data-content="' . $hint_update . '" data-original-title="<i class=\'ace-icon fa fa-exclamation-triangle\'></i> Gợi ý cập nhật">Xem gợi ý cập nhật hồ sơ</a>';
                        }
                        else if($per_complete < 60 && $per_complete >= 30)
                        {
                            echo 'Mức độ hoàn thành <span class="green bolder">' . $per_complete . '%</span>';
                            echo '<br>Bạn cần cập nhật hồ sơ của mình';
                            echo '<br><a href="javascript: void(0)" class="popover-warning" data-rel="popover" data-placement="bottom" title="" data-content="' . $hint_update . '" data-original-title="<i class=\'ace-icon fa fa-exclamation-triangle\'></i> Gợi ý cập nhật">Xem gợi ý cập nhật hồ sơ</a>';
                        }
                        else if($per_complete < 30 && $per_complete > 0)
                        {
                            echo 'Mức độ hoàn thành <span class="green bolder">' . $per_complete . '%</span>';
                            echo '<br>Hồ sơ của bạn còn nhiều thiếu sót';
                            echo '<br><a href="javascript: void(0)" class="popover-warning" data-rel="popover" data-placement="bottom" title="" data-content="' . $hint_update . '" data-original-title="<i class=\'ace-icon fa fa-exclamation-triangle\'></i> Gợi ý cập nhật">Xem gợi ý cập nhật hồ sơ</a>';
                        }
                        else if($per_complete == 0)
                        {
                            echo '<span class="text-warning bolder">Ohs! Hồ sơ của bạn chưa có thông tin gì</span>';
                            echo '<br><a href="javascript: void(0)" class="popover-warning" data-rel="popover" data-placement="bottom" title="" data-content="' . $hint_update . '" data-original-title="<i class=\'ace-icon fa fa-exclamation-triangle\'></i> Gợi ý cập nhật">Xem gợi ý cập nhật hồ sơ</a>';
                        }
                        ?>
                        <br>
                    </div>
                </div>
                <div class="search-item-clear"></div>
                <div class="background-white background-padding">
                    <div class="resume-status-header">
                        <h4>CẬP NHẬT CV</h4>
                    </div>
                    <div class="update_f_profile">
                        <form>
                            <input id="file-cv" type="file">
                        </form>
                    </div>
                </div>
                <div class="search-item-clear"></div>
                <div class="background-white background-padding">
                    <div class="resume-status-header">
                        <h4>THIẾT LẬP TÌM KIẾM</h4>
                    </div>
                    <div class="search-setting">
                        <div class="checkbox">
                            <label>
                                <input id="ckhAllowSearch" name="form-field-checkbox" class="ace" type="checkbox" <?php if($members['Member']['allow_search'] == 1) { echo 'checked';}?>>
                                <span class="lbl"> Cho phép tìm kiếm hồ sơ</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="search-item-clear"></div>
                <div class="background-white background-padding">
                    <div class="resume-status-header">
                        <h4>THÔNG BÁO VIỆC LÀM</h4>
                    </div>
                    <div class="">
                        <div class="register-recruitment-box">
                            <div class="register-recruitment">
                                <!--                            <i class="fa fa-bell"></i>-->
                                <div class="icon">
                                    <i class="fa fa-bell"></i>
                                </div>
                                <div class="text">Thông báo việc làm</div>
                            </div>
                            <div class="padding-8">
                                Gửi việc làm bạn quan tâm qua email
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modal-->
<!--Modal general-->
<div>
    <div class="modal fade" id="modalGeneral" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thông tin chung</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmUpdateGeneral', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Họ tên <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('fullname', array('id' => 'fullname', 'class' => '', 'label' => false, 'value' => $members['Member']['fullname'], 'title' => 'Họ tên'));
                                ?>
                                <span hidden="hidden" class="error-label error-fullname">Họ tên không để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Chức danh <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('title', array('id' => 'title', 'class' => '', 'label' => false, 'value' => $members['Member']['title'], 'title' => 'Chức danh', 'placeholder' => 'Ví dụ: \'PHP Developer\' hoặc \'Sales Manager\''));
                                ?>
                                <span hidden="hidden" class="error-label error-title">Chức danh không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Số năm kinh nghiệm <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('experience', array('id' => 'experience', 'type' => 'text', 'label' => false, 'class' => 'form-control', 'title' => 'Số năm kinh nghiệm', 'value'=> $members['Member']['experience']));
                                ?>
                                <span hidden="hidden" class="error-label error-experience">Số năm kinh nghiệm không để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Cấp bậc hiện tại <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('level', array('id' => 'level', 'class' => 'levels', 'label' => false, 'default' => $members['Member']['level_id'], 'options' => $levels, 'empty' => '', 'style' => 'width: 100% !important'));
                                ?>
                                <span hidden="hidden" class="error-label error-level">Chọn cấp bậc hiện tại</span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnSaveGeneral" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSkill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cập nhật kỹ năng</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmUpdateSkill', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                Kỹ năng <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-8">
                                <?php
                                echo $this->Form->input('skills', array('id' => 'skills', 'class' => 'skills', 'label' => false, 'selected' => $skill_selected, 'options' => $skills, 'empty' => '', 'style' => 'width: 100% !important', 'multiple' => true));
                                ?>
                                <span hidden="hidden" class="error-label error-skills">Chọn kỹ năng của bạn</span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnSaveSkill" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <!--Avatar-->
    <div class="modal fade" id="modalAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cập nhật ảnh</h4>
                </div>
                <div class="modal-body">
                    <?php echo $this->Form->create('Member', array('id' => 'frmChangeAvatar', 'class' => 'form-horizontal', 'novalidate' => true, 'type' => 'file', 'action' => '/update_avatar'));?>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php echo $this->Form->input('avatar', array('id' => 'id-input-file-3', 'label' => false, 'title' => 'Chọn hình ảnh', 'type' => 'file'));?>
                        </div>
                    </div>
                    <?php
                    echo $this->Form->end();?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnChangeAvatar" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal Summary-->
    <div class="modal fade" id="modalSummary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Giới thiệu về bản thân</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmUpdateSummary', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <div class="label-summary">
                                Nhập vài dòng giới thiệu về bạn
                            </div>
                            <div class="col-sm-12">
                                <?php
                                echo $this->Form->input('summary', array('type' => 'textarea', 'id' => 'summary', 'class' => 'form-control', 'label' => false, 'value' => $members['Member']['introduce'], 'title' => 'Giới thiệu về bản thân'));
                                ?>
                                <span hidden="hidden" class="error-label error-summary">Không được để trống</span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnSaveSummary" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal Add Language-->
    <div class="modal fade" id="modalAddLanguage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thêm ngôn ngữ</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmAddLanguage', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <label class="control-label col-sm-4">
                                Ngôn ngữ <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-5">
                                <?php
                                echo $this->Form->input('language', array('type' => 'select', 'id' => 'language', 'class' => 'form-control language-opt', 'label' => false, 'options' => $languages, 'empty' => 'Chọn ngôn ngữ', 'style' => 'width: 100% !important'));
                                ?>
                                <span hidden="hidden" class="error-label error-language">Vui lòng chọn ngôn ngữ</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">
                                Trình độ <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-5">
                                <?php
                                echo $this->Form->input('language_level', array('type' => 'select', 'id' => 'language_level', 'class' => 'form-control language_level-opt', 'label' => false, 'options' => $languages_levels, 'empty' => 'Chọn trình độ ngôn ngữ', 'style' => 'width: 100% !important'));
                                ?>
                                <span hidden="hidden" class="error-label error-language_level">Vui lòng trình độ</span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnAddLanguage" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditLanguage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Sửa ngôn ngữ</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmAddLanguage', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <label class="control-label col-sm-4">
                                Ngôn ngữ <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-5">
                                <?php
                                echo $this->Form->input('language', array('type' => 'select', 'id' => 'e_language', 'class' => 'form-control language-opt', 'label' => false, 'options' => $languages, 'empty' => 'Chọn ngôn ngữ', 'style' => 'width: 100% !important'));
                                echo $this->Form->input('id', array('type' => 'hidden', 'id' => 'ml_id', 'class' => 'form-control', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-e_language">Vui lòng chọn ngôn ngữ</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">
                                Trình độ <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-5">
                                <?php
                                echo $this->Form->input('language_level', array('type' => 'select', 'id' => 'e_language_level', 'class' => 'form-control language_level-opt', 'label' => false, 'options' => $languages_levels, 'empty' => 'Chọn trình độ ngôn ngữ', 'style' => 'width: 100% !important'));
                                ?>
                                <span hidden="hidden" class="error-label error-e_language_level">Vui lòng trình độ</span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnEditLanguage" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddWork" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thêm công việc</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmAddWork', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Chức danh <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('w_title', array('id' => 'w_title', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-w_title">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Công ty <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('w_company_name', array('id' => 'w_company_name', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-w_company_name">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Từ tháng <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-5">
                                <?php
                                echo $this->Form->input('w_from', array('id' => 'w_from', 'type' => 'text', 'label' => false, 'class' => 'form-control month-picker'));
                                ?>
                                <span hidden="hidden" class="error-label error-w_from">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Đến tháng <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-5">
                                <?php
                                echo $this->Form->input('w_to', array('id' => 'w_to', 'type' => 'text', 'label' => false, 'class' => 'form-control month-picker'));
                                ?>
                                <span hidden="hidden" class="error-label error-w_to">Không được để trống</span>
                            </div>
                            <div class="col-sm-2">
                                <div class="checkbox">
                                    <label>
                                        <input name="" id="w_now" class="ace" type="checkbox">
                                        <span class="lbl"> Hiện tại</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Mô tả công việc
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('w_summary', array('type' => 'textarea', 'id' => 'w_summary', 'class' => 'form-control', 'label' => false));
                                ?>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnSaveAddWork" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditWork" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Sửa công việc</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmEditWork', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Chức danh <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('e_w_title', array('id' => 'e_w_title', 'class' => '', 'label' => false));
                                echo $this->Form->input('e_w_id', array('id' => 'e_w_id', 'class' => '', 'label' => false, 'type' => 'hidden'));
                                ?>
                                <span hidden="hidden" class="error-label error-e_w_title">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Công ty <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('e_w_company_name', array('id' => 'e_w_company_name', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-e_w_company_name">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Từ tháng <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-5">
                                <?php
                                echo $this->Form->input('e_w_from', array('id' => 'e_w_from', 'type' => 'text', 'label' => false, 'class' => 'form-control month-picker'));
                                ?>
                                <span hidden="hidden" class="error-label error-e_w_from">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Đến tháng <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-5">
                                <?php
                                echo $this->Form->input('e_w_to', array('id' => 'e_w_to', 'type' => 'text', 'label' => false, 'class' => 'form-control month-picker'));
                                ?>
                                <span hidden="hidden" class="error-label error-e_w_to">Không được để trống</span>
                            </div>
                            <div class="col-sm-2">
                                <div class="checkbox">
                                    <label>
                                        <input name="" id="e_w_now" class="ace" type="checkbox">
                                        <span class="lbl"> Hiện tại</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Mô tả công việc
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('e_w_summary', array('type' => 'textarea', 'id' => 'e_w_summary', 'class' => 'form-control', 'label' => false));
                                ?>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnSaveEditWork" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddDegree" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thêm học vấn</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmAddDegree', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Chuyên ngành <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('d_specialized', array('id' => 'd_specialized', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-d_specialized">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Trường <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('d_school', array('id' => 'd_school', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-d_school">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Trình độ <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('d_degree', array('id' => 'd_degree', 'class' => '', 'label' => false, 'type' => 'select', 'options' => $degrees, 'style' => 'width: 100% !important', 'empty' => ''));
                                ?>
                                <span hidden="hidden" class="error-label error-d_degree">Vui lòng chọn</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Từ tháng <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->input('d_from', array('id' => 'd_from', 'type' => 'text', 'label' => false, 'class' => 'form-control month-picker'));
                                ?>
                                <span hidden="hidden" class="error-label error-d_from">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Đến tháng <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->input('d_to', array('id' => 'd_to', 'type' => 'text', 'label' => false, 'class' => 'form-control month-picker'));
                                ?>
                                <span hidden="hidden" class="error-label error-d_to">Không được để trống</span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnSaveAddDegree" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditDegree" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Sửa học vấn</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmEditDegree', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Chuyên ngành <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('ed_specialized', array('id' => 'ed_specialized', 'class' => '', 'label' => false));
                                echo $this->Form->input('ed_id', array('id' => 'ed_id', 'class' => '', 'label' => false, 'type' => 'hidden'));
                                ?>
                                <span hidden="hidden" class="error-label error-ed_specialized">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Trường <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('ed_school', array('id' => 'ed_school', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-ed_school">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Trình độ <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('ed_degree', array('id' => 'ed_degree', 'class' => '', 'label' => false, 'type' => 'select', 'options' => $degrees, 'style' => 'width: 100% !important', 'empty' => ''));
                                ?>
                                <span hidden="hidden" class="error-label error-ed_degree">Vui lòng chọn</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Từ tháng <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->input('ed_from', array('id' => 'ed_from', 'type' => 'text', 'label' => false, 'class' => 'form-control month-picker'));
                                ?>
                                <span hidden="hidden" class="error-label error-ed_from">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Đến tháng <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->input('ed_to', array('id' => 'ed_to', 'type' => 'text', 'label' => false, 'class' => 'form-control month-picker'));
                                ?>
                                <span hidden="hidden" class="error-label error-ed_to">Không được để trống</span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnSaveEditDegree" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddRefer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thêm thông tin tham khảo</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmAddRefer', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Họ tên <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('r_fullname', array('id' => 'r_fullname', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-r_fullname">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Chức danh <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('r_title', array('id' => 'r_title', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-r_title">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Công ty <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('r_company', array('id' => 'r_company', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-r_company">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Địa chỉ email
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('r_email', array('id' => 'r_email', 'type' => 'text', 'label' => false, 'class' => 'form-control'));
                                ?>
                                <span hidden="hidden" class="error-label error-r_email">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Số điện thoại
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('r_phone', array('id' => 'r_phone', 'type' => 'text', 'label' => false, 'class' => 'form-control'));
                                ?>
                                <span hidden="hidden" class="error-label error-r_phone">Không được để trống</span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnSaveAddRefer" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditRefer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Sửa thông tin tham khảo</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php
                        echo $this->Form->create('Member', array('id' => 'frmEditRefer', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                        ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Họ tên <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('er_fullname', array('id' => 'er_fullname', 'class' => '', 'label' => false));
                                echo $this->Form->input('er_id', array('id' => 'er_id', 'class' => '', 'label' => false, 'type' => 'hidden'));
                                ?>
                                <span hidden="hidden" class="error-label error-er_fullname">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Chức danh <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('er_title', array('id' => 'er_title', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-er_title">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Công ty <font class="label-require">(*)</font>
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('er_company', array('id' => 'er_company', 'class' => '', 'label' => false));
                                ?>
                                <span hidden="hidden" class="error-label error-er_company">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Địa chỉ email
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('er_email', array('id' => 'er_email', 'type' => 'text', 'label' => false, 'class' => 'form-control'));
                                ?>
                                <span hidden="hidden" class="error-label error-er_email">Không được để trống</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Số điện thoại
                            </label>
                            <div class="col-sm-7">
                                <?php
                                echo $this->Form->input('er_phone', array('id' => 'er_phone', 'type' => 'text', 'label' => false, 'class' => 'form-control'));
                                ?>
                                <span hidden="hidden" class="error-label error-er_phone">Không được để trống</span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                    <button id="btnSaveEditRefer" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditDesire" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Công việc mong muốn của bạn</h4>
            </div>
            <div class="modal-body">
                <div class="">
                    <?php
                    echo $this->Form->create('Member', array('id' => 'frmEditDesire', 'method' => 'post', 'novalidate' => true, 'class' => ''));
                    ?>
                    <div class="form-group">
                        <label>
                            Ngành nghề <font class="label-require">(*)</font>
                        </label>
                        <div>
                            <?php
                            echo $this->Form->input('desire_job', array('id' => 'desire_job', 'class' => '', 'label' => false, 'type' => 'select', 'options' => $jobs, 'style' => 'width: 100% !important', 'empty' => '', 'multiple' => true, 'selected' => $desire_job_selected));
                            ?>
                            <span hidden="hidden" class="error-label error-desire_job">Chọn ngành nghề mong muốn</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Nơi làm việc <font class="label-require">(*)</font>
                        </label>
                        <div>
                            <?php
                            echo $this->Form->input('desire_province', array('id' => 'desire_province', 'class' => '', 'label' => false, 'type' => 'select', 'options' => $provinces, 'style' => 'width: 100% !important', 'empty' => '', 'multiple' => true, 'selected' => $desire_province_selected));
                            ?>
                            <span hidden="hidden" class="error-label error-desire_province">Chọn nơi làm việc mong muốn</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>
                                    Cấp bậc <font class="label-require">(*)</font>
                                </label>
                                <div>
                                    <?php
                                    echo $this->Form->input('desire_level', array('id' => 'desire_level', 'class' => '', 'label' => false, 'type' => 'select', 'options' => $levels, 'style' => 'width: 100% !important', 'empty' => '', 'default' => $desire_level_id));
                                    ?>
                                    <span hidden="hidden" class="error-label error-desire_level">Chọn cấp bậc mong muốn</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>
                                    Mức lương <font class="label-require">(*)</font>
                                </label>
                                <div>
                                    <?php
                                    echo $this->Form->input('desire_salary', array('id' => 'desire_salary', 'type' => 'text', 'label' => false, 'class' => 'form-control', 'value' => $desire_salary));
                                    ?>
                                    <span hidden="hidden" class="error-label error-desire_salary">Nhập mức lương mong muốn</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label>
                            Phúc lợi
                        </label>
                        <div class="checkbox">
                            <div class="row">
                                <?php
                                if(isset($benefits) && count($benefits) > 0)
                                {
                                    foreach ($benefits as $item)
                                    {
                                        $checked = '';
                                        if(!is_null($desire_benefit_selected) && in_array($item['Benefit']['id'], $desire_benefit_selected))
                                        {
                                            $checked = 'checked="checked"';
                                        }
                                        ?>
                                        <div class="col-sm-6 container-chk-benefit">
                                            <label>
                                                <input name="desire_benefit" class="ace chk-benefit" type="checkbox" value="<?php echo $item['Benefit']['id'];?>" <?php echo $checked;?>>
                                                <span class="lbl <?php if($checked != ''){ echo 'span-selected';}?>">
                                                    <i class="<?php echo $item['Benefit']['icon'];?>"></i>
                                                    <?php echo $item['Benefit']['benefit_name'];?>
                                                </span>
                                            </label>
                                        </div>

                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <span hidden="hidden" class="error-label error-desire_benefit"></span>
                        </div>
                    </div>
                    <?php
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Hủy</button>
                <button id="btnSaveEditDesire" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
            </div>
        </div>
    </div>
</div>
</div>
    <!--End modal-->
<script>
    $(function () {
        $('.month-picker').MonthPicker({
            Button: false,
            Animation: 'slideToggle',
        });
        $('#id-input-file-3').ace_file_input({
            style: 'well',
            btn_choose: 'Click vào đây để chọn ảnh',
            btn_change: null,
            no_icon: 'ace-icon fa fa-image',
            droppable: true,
            thumbnail: 'large',//large | fit

            preview_error : function(filename, error_code) {
            }

        }).on('change', function(){
        });
        $('#btnChangeAvatar').click(function () {
            $('#frmChangeAvatar').submit();
        });
        $('#desire_province').select2({
            minimunResultsForSearch: -1,
            placeholder: 'Chọn nơi làm việc mong muốn',
            maximumSelectionLength: 3
        });
        $('#desire_job').select2({
            minimunResultsForSearch: -1,
            placeholder: 'Chọn ngành nghề mong muốn',
            maximumSelectionLength: 3
        });
        $('#desire_level').select2({
            minimumResultsForSearch: -1,
            placeholder: 'Chọn cấp bậc mong muốn'
        });
        $('.levels').select2({
            minimumResultsForSearch: -1,
            placeholder: 'Chọn cấp bậc'
        });
        $('.language-opt').select2({
            minimumResultsForSearch: -1,
            placeholder: 'Chọn ngôn ngữ'
        });
        $('.language_level-opt').select2({
            minimumResultsForSearch: -1,
            placeholder: 'Chọn trình độ ngôn ngữ'
        });
        $('#d_degree').select2({
            minimumResultsForSearch: -1,
            placeholder: 'Chọn trình độ'
        });
        $('#ed_degree').select2({
            minimumResultsForSearch: -1,
            placeholder: 'Chọn trình độ'
        });
        $('#skills').select2({
            minimumResultsForSearch: -1,
            placeholder: 'Kỹ năng của bạn'
        });
        $('[data-rel=popover]').popover({html:true});
        $('#file-cv').ace_file_input({
            style: 'well',
            btn_choose: 'Cập nhật CV của bạn',
            btn_change: null,
            no_icon: 'ace-icon fa fa-file-text-o',
            droppable: true,
            thumbnail: 'small',//large | fit
            preview_error : function(filename, error_code) {
            }

        }).on('change', function(){
        });
        $('#desire_salary').keyup(function () {
            format_num(this);
        });
    })
</script>