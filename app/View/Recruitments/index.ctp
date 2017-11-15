<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="header-index">
                <h3>
                    VIỆC LÀM NỔI BẬT
                </h3>
            </div>
            <div class="recruitment-container">
                <?php
                if(isset($recruitments) && count($recruitments) > 0)
                {
                    $has_recruitment_saved = false;
                    if(isset($arr_recruitments_saved) && count($arr_recruitments_saved) > 0)
                    {
                        $has_recruitment_saved = true;
                    }
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
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#category_search').select2({
            placeholder: 'Tất cả ngành nghề'
        });
        $('#province_search').select2({
            placeholder: 'Tất cả địa điểm'
        });
        $('.div-index-primary').show();
    })
</script>