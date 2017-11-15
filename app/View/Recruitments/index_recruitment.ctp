<?php
$salary_level = array();
$salary_level[0] = array(
    'value' => '0_3000000',
    'text' => '<= 3 triệu'
);
$salary_level[1] = array(
    'value' => '3000000_5000000',
    'text' => '3 - 5 triệu'
);
$salary_level[2] = array(
    'value' => '5000000_7000000',
    'text' => '5 - 7 triệu'
);
$salary_level[3] = array(
    'value' => '7000000_10000000',
    'text' => '7-10 triệu'
);
$salary_level[4] = array(
    'value' => '10000000_20000000',
    'text' => '10 - 20 triệu'
);
$salary_level[5] = array(
    'value' => '20000000_50000000',
    'text' => '20 - 50 triệu'
);
$salary_level[6] = array(
    'value' => '50000000_0',
    'text' => '>= 50 triệu'
);
$has_recruitment_saved = false;
if(isset($arr_recruitments_saved) && count($arr_recruitments_saved) > 0)
{
    $has_recruitment_saved = true;
}
//
?>
<div class="background-primary">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="background-white">
                    <div class="div-search-second div-index-primary">
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" placeholder="Từ khóa tìm kiếm" id="key_word" value="<?php echo $s_key_word;?>">
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group has-feedback">
                                    <?php
                                    echo $this->Form->input('category_search', array('type' => 'select', 'label' => false, 'id' => 'category_search', 'options' => $jobs, 'empty' => 'Tất cả ngành nghề', 'style' => 'width: 100% !important', 'default' => $s_job_link))
                                    ?>
                                    <span class="glyphicon  glyphicon-list form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group has-feedback">
                                    <?php
                                    echo $this->Form->input('province_search', array('type' => 'select', 'label' => false, 'id' => 'province_search', 'options' => $provinces, 'empty' => 'Tất cả địa điểm', 'style' => 'width: 100% !important', 'default' => $s_province_link))
                                    ?>
                                    <span class="glyphicon  glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-primary btn-search-index" id="btnSearchPrimary"><i class="fa fa-search"></i> Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 text-center hidden-xs" style="margin-bottom: 10px">
                <div class="text-center text-danger">
                    <img src="https://mediaz.vn/wp-content/uploads/2014/09/Banner-01-1170x227.png">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7 col-sm-push-3">
                <div class="background-white">
                    <div class="recruitment-list-header">
                        <div class="row">
                            <div class="col-sm-6 col-sort">
                                Sắp xếp:
                                <?php echo $this->Paginator->sort('Order.packet_id', 'Mặc định', array('direction' => 'desc'));?> |
                                <?php echo $this->Paginator->sort('Order.created', 'Mới nhất', array('direction' => 'desc'));?> |
                                <?php echo $this->Paginator->sort('Recruitment.salary_min', 'Lương');?>
                            </div>
                            <div class="col-sm-6 text-right bigger-150">
                                <?php echo number_format($this->Paginator->param('count'), 0, '', '.');?> việc làm
                            </div>
                        </div>
                    </div>
                    <div class="recruitment-container">
                        <?php
                        if(isset($recruitments) && count($recruitments) > 0)
                        {
                            foreach ($recruitments as $item)
                            {
                                ?>
                                <div class="recruitment-item packet-<?php echo $item['Packet']['id'];?>">
                                    <div class="row">
                                        <div class="col-sm-2 col-xs-3 image">
                                            <a href="/tim-viec-lam/<?php echo $item['Recruitment']['link'];?>/<?php echo $item['Recruitment']['id'];?>" title="<?php echo $item['Recruitment']['title'];?>">
                                                <img src="/uploads/company/<?php echo $item['Employer']['logo'];?>">
                                            </a>
                                        </div>
                                        <div class="div-title col-sm-9 col-xs-8">
                                            <a href="/tim-viec-lam/<?php echo $item['Recruitment']['link'];?>/<?php echo $item['Recruitment']['id'];?>" title="<?php echo $item['Recruitment']['title'];?>">
                                                <h3>
                                                    <?php echo htmlentities($item['Recruitment']['title'], ENT_QUOTES, 'UTF-8');?>
                                                </h3>
                                            </a>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <span class="salary">
                                                        <i class="fa fa-dollar"> </i>
                                                        <?php
                                                        if($item['Recruitment']['hide_salary'] == 1)
                                                        {
                                                            echo 'Lương thỏa thuận';
                                                        }
                                                        else
                                                        {
                                                            echo number_format($item['Recruitment']['salary_min'], 0, '', '.');
                                                            echo ' - ';
                                                            echo number_format($item['Recruitment']['salary_max'], 0, '', '.');
                                                        }
                                                        ?>
                                                    </span>
                                                    <span class="company-name">
                                                        <?php echo htmlentities($item['Employer']['company_name'], ENT_QUOTES, 'UTF-8');?>
                                                    </span>
                                                    <span class="date">
                                                        Đăng tuyển
                                                        <?php echo $this->Lib->convertDateTime_Mysql_to_Date($item['Order']['created']);?>
                                                        , làm việc tại
                                                        <?php
                                                        if(count($item['RecruitmentProvince']) > 0)
                                                        {
                                                            $count_province = count($item['RecruitmentProvince']);
                                                            for($i = 0; $i < $count_province; $i++)
                                                            {
                                                                $rp = $item['RecruitmentProvince'][$i];
                                                                echo $rp['Province']['provincename'];
                                                                if($i < $count_province - 1)
                                                                {
                                                                    echo ' | ';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-1 text-right">
                                            <?php
                                                if($has_recruitment_saved == true)
                                                {
                                                    if(in_array($item['Recruitment']['id'], $arr_recruitments_saved))
                                                    {
                                                        ?>
                                                        <span class="btn-save-recruitment recruitment-save recruitment-saved" data-recruitment_id="<?php echo $item['Recruitment']['id'];?>">
                                                            <i class=" fa fa-heart saved"></i>
                                                        </span>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <span class="btn-save-recruitment recruitment-save" data-recruitment_id="<?php echo $item['Recruitment']['id'];?>">
                                                            <i class="fa fa-heart-o"></i>
                                                        </span>
                                                        <?php
                                                    }
                                                }
                                                else
                                                {
                                                    ?>
                                                    <span class="recruitment-save btn-save-recruitment" data-recruitment_id="<?php echo $item['Recruitment']['id'];?>">
                                                        <i class="fa fa-heart-o"></i>
                                                    </span>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <div>
                                <hr>
                                <div class="text-danger bigger-120 bolder" style="padding-left: 15px">
                                    Không tìm thấy công việc theo yêu cầu
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="recruitment-list-footer text-center">
                        <?php if($this->params['paging']['Recruitment']['pageCount'] > 1):?>
                            <div class="pagination">
                                <ul class="pagination">
                                    <?php
                                    //
                                    $here = $this->here;
                                    $len_here = strlen($here);
                                    $here = substr($here, 1, $len_here);
                                    $this->Paginator->options(array(
                                        'url'=> array(
                                            'controller' => '/',
                                            'action' => '/',
                                            $here
                                        )
                                    ));
                                    //set querystring
                                    $this->Paginator->options['url']['?'] = $this->params['url'];
                                    echo urldecode($this->Paginator->numbers(
                                        array(
                                            'separator' => '',
                                            'currentTag' => 'a',
                                            'currentClass' => 'active',
                                            'ellipsis'=>'<a>...</a>',
                                            'modulus' => 4,
                                            'first' => 2,
                                            'last' => 2
                                        )));
                                    ?>
                                </ul>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
                <div class="search-item-clear"></div>
            </div>
            <div class="col-sm-3  col-sm-pull-7">
                <div class="background-white">
                    <div class="search-item">
                        <div class="search-item-header">
                            <h4>TÌM THEO CHỨC VỤ</h4>
                        </div>
                        <div class="search-item-container">
                            <?php
                            if(isset($levels) && count($levels) > 0)
                            {
                                foreach ($levels as $level)
                                {
                                    ?>
                                    <div class="checkbox">
                                        <label>
                                            <input name="" class="ace s_level" type="checkbox" value="<?php echo $level['Level']['id'];?>" <?php if($level['Level']['id'] == $level_id) { echo 'checked';}?>>
                                            <span class="lbl" <?php if($level['Level']['id'] == $level_id) { echo 'style="font-weight: bolder;"';}?>>
                                                <?php echo $level['Level']['levelname'];?>
                                            </span>
                                        </label>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="search-item-clear"></div>
                <div class="background-white">
                    <div class="search-item">
                        <div class="search-item-header">
                            <h4>TÌM THEO MỨC LƯƠNG</h4>
                        </div>
                        <div class="search-item-container">
                            <?php
                            if(isset($salary_level) && count($salary_level) > 0)
                            {
                                foreach ($salary_level as $s)
                                {
                                    ?>
                                    <div class="checkbox">
                                        <label>
                                            <input name="" class="ace s_salary" value="<?php echo $s['value'];?>" type="checkbox" <?php if($s['value'] == $s_salary) { echo 'checked';};?>>
                                            <span class="lbl" <?php if($s['value'] == $s_salary) { echo 'style="font-weight: bolder;"';};?>>
                                                <?php echo $s['text'];?>
                                            </span>
                                        </label>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="search-item-clear"></div>
<!--                Quảng cáo-->
                <div>
                    <img src="/uploads/advertise/qc_1.jpg" style="width: 100%">
                </div>
<!--                End quảng cáo-->
            </div>
            <div class="col-sm-2">
                <div class="background-white">
                    <div class="register-recruitment-box">
                        <div class="register-recruitment">
<!--                            <i class="fa fa-bell"></i>-->
                            <div class="icon">
                                <i class="fa fa-bell"></i>
                            </div>
                            <div class="text">Thông báo việc làm</div>
                        </div>
                        <div class="">
                            Gửi việc làm bạn quan tâm qua email
                        </div>
                    </div>
                </div>
                <div class="search-item-clear"></div>
                <div class="background-white">
                    <div class="company-feature-list">
                        <div class="company-feature-list-header">
                            <h5>CÔNG TY NỔI BẬT</h5>
                        </div>
                        <?php
                        if(isset($company_features) && count($company_features) > 0)
                        {
                            foreach ($company_features as $company_feature)
                            {
                                ?>
                                <div class="item">
                                    <img src="/uploads/company/<?php echo $company_feature['Employer']['logo'];?>">
                                    <div class="middle">
                                        <a class="" href="/?companyId=<?php echo $company_feature['Employer']['id'];?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#category_search').select2({
//            placeholder: 'Tất cả ngành nghề'
        });
        $('#province_search').select2({
//            placeholder: 'Tất cả địa điểm'
        });
        $('.div-search-second').show();
        //
        var href = window.location.pathname;
        //Click button
        $('#btnSearchPrimary').click(function () {
            search_index();
        });
        //Enter textbox
        $('#key_word').keyup(function(e){
            if(e.keyCode == 13)
            {
                search_index();
            }
        });
        $('#category_search').change(function(){
            search_index();
        });
        $('#province_search').change(function(){
            search_index();
        });
        //
        var key_word = '<?php echo $s_key_word;?>';
        var level = '<?php echo $level_id;?>';
        var salary = '<?php echo $s_salary;?>';
        $('.s_level').on('click', function(){
            if($(this).is(':checked'))
            {

                window.location = href + '?level=' + $(this).val() + '&key_word=' + key_word + '&salary=' + salary;
            }
            else
            {
                window.location = href + '?key_word=' + key_word + '&salary=' + salary;
            }
        });
        $('.s_salary').on('click', function(){
            if($(this).is(':checked'))
            {
                window.location = href + '?level=' + level + '&key_word=' + key_word + '&salary=' + $(this).val();
            }
            else
            {
                window.location = href + '?level=' + level + '&key_word=' + key_word;
            }

        });


        //Function

    })
</script>
