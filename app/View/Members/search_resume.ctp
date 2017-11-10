<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="frm-search-resume">
                <h4 class="">TÌM ỨNG VIÊN</h4>
                <hr>
                <form id="frmSearchResume" class="form-horizontal" method="get">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <div class="input-group">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-folder-open"></i>
                            </span>
                                <?php
                                echo $this->Form->input('s_jobs', array('type' => 'select', 'label' => false, 'name' => 's_jobs', 'id' => 's_jobs', 'options' => $jobs, 'empty' => '', 'default' => $s_jobs_selected, 'multiple' => true));
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-map-marker"></i>
                            </span>
                                <?php
                                echo $this->Form->input('s_provinces', array('type' => 'select', 'label' => false, 'name' => 's_provinces', 'id' => 's_provinces', 'options' => $provinces, 'empty' => '', 'default' => $s_provinces_selected, 'multiple' => true
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <div class="input-group">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-graduation-cap"></i>
                            </span>
                                <?php
                                echo $this->Form->input('s_level', array('type' => 'select', 'label' => false, 'name' => 's_level', 'id' => 's_level', 'options' => $levels, 'empty' => 'Tất cả', 'default' => $s_level, 'style' => 'width: 100% !important'));
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-dollar"></i>
                            </span>
                                <input type="text" name="s_title" id="s_title" placeholder="Chức danh, vị trí. VD: 'PHP Developer' hoặc 'Giám sát bán hàng'" value="<?php echo $s_title;?>">
                            </div>
                        </div>
                    </div>
                    <!--                Tìm nâng cao-->
                    <div>

                    </div>
                    <div class="search-advanced">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-dollar"></i>
                                </span>
                                    <input class="form-control" id="s_salary_min" name="s_salary_min" type="text" style="width: 50%; float: left" placeholder="Mức lương từ(VND)" value="<?php echo $s_salary_min;?>">
                                    <input class="form-control" id="s_salary_max" name="s_salary_max" type="text" style="width: 50%; float: left; margin-left: -1px" placeholder="Đến(VND)" value="<?php echo $s_salary_max;?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-birthday-cake"></i>
                                </span>
                                    <input class="form-control" id="s_age_min" name="s_age_min" type="text" style="width: 50%; float: left" placeholder="Tuổi từ" value="<?php echo $s_age_min;?>">
                                    <input class="form-control" id="s_age_max" name="s_age_max" type="text" style="width: 50%; float: left; margin-left: -1px" placeholder="Đến"  value="<?php echo $s_age_max;?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-bolt"></i>
                                </span>
                                    <input class="form-control" id="s_experience" name="s_experience" type="text" placeholder="Số năm kinh nghiệm" value="<?php echo $s_experience;?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-transgender"></i>
                                </span>
                                    <?php
                                    echo $this->Form->input('s_gender', array(
                                        'type' => 'select',
                                        'name' => 's_gender',
                                        'id' => 's_gender',
                                        'label' => false,
                                        'options' => array(
                                            '' => 'Bất kỳ',
                                            '1' => 'Nam',
                                            '0' => 'Nữ'
                                        ),
                                        'default' => $s_gender
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-right">
                            <a href="/nha-tuyen-dung/tim-ung-vien">
                                Xóa tìm kiếm
                            </a>
                            <button type="submit" id="btnSearchResume" class="btn btn-warning">
                                <i class="fa fa-search"></i>
                                Tìm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="result-resume">
                <div class="header-result">
                    <h4 class="bigger-200">
                        <?php echo $this->Paginator->param('count') > 0? number_format($this->Paginator->param('count'), 0, '', '.') . ' hồ sơ được tìm thấy' : 'Không tìm thấy hồ sơ theo yêu cầu';?>
                    </h4>
                </div>
                <?php
                if(isset($members_resumes) && count($members_resumes) > 0)
                {
                    $i = 0;
                    $arr_member_id = array();
                    foreach ($members_resumes as $item)
                    {
                        $arr_member_id[$i] = $item['Member']['id'];
                        $i = $i + 1;
                        ?>
                        <div class="item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>
                                        <a href="/nha-tuyen-dung/tim-ung-vien/detail/<?php echo $item['Member']['id'];?>">
                                            <?php
                                            if($item['Member']['title']) { echo htmlentities($item['Member']['title'], ENT_QUOTES, 'UTF-8');}
                                            ?>
                                        </a>
                                    </h4>
                                </div>
                                <div class="col-sm-3">
                                    <?php
                                    if(isset($item['DesireJob']) && count($item['DesireJob']) > 0)
                                    {
                                        foreach ($item['DesireJob'] as $dj)
                                        {
                                            echo '<i class="fa fa-folder-open"> </i> ' . $dj['Job']['jobname']. '<br>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-2">
                                    <?php
                                    if(isset($item['DesireProvince']) && count($item['DesireProvince']) > 0)
                                    {
                                        foreach ($item['DesireProvince'] as $dp)
                                        {
                                            echo '<i class="fa fa-map-marker"> </i> ' .  $dp['Province']['provincename']. '<br>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-1 text-center">
                                    <?php
                                    if($item['Member']['experience'])
                                    {
                                        echo '<span class="blue bolder">' . $item['Member']['experience'] . '</span> năm';
                                    }
                                    echo '<br>';
                                    if($item['Desire']['salary'])
                                    {
                                        echo '<span class="blue bolder">' . number_format($item['Desire']['salary'], 0, '', '.') . '</span>';
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-2 text-center">
                                    <?php
                                    echo  '<i class="fa fa-download"></i> ' . '<span class="bigger-110">' . $item['Member']['count_download'] . '</span>';
                                    echo ' | ';
                                    echo  '<i class="fa fa-eye"></i> ' . '<span class="bigger-110">' . $item['Member']['view'] . '</span>';
                                    echo '<br>Cập nhật ' . $this->Lib->convertDateTime_Mysql_to_Date($item['Member']['lastlogin']);
                                    ?>
                                </div>
                                <div class="col-sm-2 text-center">
                                    <?php
                                    if($item['Member']['f_profile'] != '' && file_exists(WWW_ROOT . '/resume/' . $item['Member']['f_profile']))
                                    {
                                        echo '<i class="fa fa-paperclip bigger-130"></i><br>Có CV đính kèm';
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-2 text-center">
                                    <em id="label-<?php echo $item['Member']['id'];?>">

                                    </em>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <div class="bigger-120 text-danger" style="margin-top: 15px !important;">
                        Vui lòng mở rộng điều kiện tìm kiếm để tìm được hồ sơ
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('[data-rel=tooltip]').tooltip();
        var member_id = [<?php echo implode($arr_member_id, ',');?>];
        $.ajax({
            url: '/members_employers/resume_saved_ajax',
            type: 'post',
            dataType: 'json',
            data: {
                member_id: member_id
            },
            success: function (data) {
                if(data != null && data.length > 0)
                {
                    var length = data.length;
                    for(var i = 0; i < length; i++)
                    {
                        if(data[i].is_saved == true)
                        {
                            $('#label-' + data[i].member_id).html('<span class="green">Đã lưu hồ sơ</span>');
                        }
                        else
                        {
                            $('#label-' + data[i].member_id).html('<span class="orange2">Đã xem</span>');
                        }
                    }
                }
            }
        });
        $('#s_jobs').select2({
            placeholder: 'Ngành nghề'
        });
        $('#s_provinces').select2({
            placeholder: 'Nơi làm việc'
        });
        $('#s_level').select2({
            minimumResultsForSearch: -1
        });
        $('#s_gender').select2({
            minimumResultsForSearch: -1
        });
        $('#s_salary_min').keyup(function (e) {
            format_num(this);
        });
        $('#s_salary_max').keyup(function (e) {
            format_num(this);
        });
    });

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>