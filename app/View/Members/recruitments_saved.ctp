<div class="background-primary">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="search-item-clear"></div>
                <div class="background-white background-padding">
                    <div class="recruitment-container recruitment-container-saved">
                        <h3>Công việc đã lưu</h3>
                        <hr>
                        <?php
                        if(isset($recruitments_saved) && count($recruitments_saved) > 0)
                        {
                            foreach ($recruitments_saved as $item)
                            {
                                ?>
                                <div class="recruitment-item recruitment-item-saved">
                                    <div class="row">
                                        <div class="col-sm-2 col-xs-3 image">
                                            <a href="/tim-viec-lam/<?php echo $item['Recruitment']['link'];?>/<?php echo $item['Recruitment']['id'];?>" title="<?php echo $item['Recruitment']['title'];?>">
                                                <img src="/uploads/company/<?php echo $item['Employer']['logo'];?>">
                                            </a>
                                        </div>
                                        <div class="div-title col-sm-6 col-xs-9">
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
                                                    <span class="date"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            Hết hạn
                                            <br>
                                            <?php
                                            echo $this->Lib->convertDateTime_Mysql_to_Date($item['Order']['expiry']);
                                            ?>
                                        </div>
                                        <div class="col-sm-2 text-center action">
                                            <?php
                                            if($item['MemberRecruitment']['is_applied'] == 1)
                                            {
                                                ?>
                                                <span class="text-success">Đã ứng tuyển</span>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a href="/tim-viec-lam/<?php echo $item['Recruitment']['link'];?>/<?php echo $item['Recruitment']['id'];?>" class="btn btn-warning btn-white btn-round">Ứng tuyển</a>
                                                <?php
                                            }
                                            ?>
                                            &nbsp;
                                            <a class="bolder delete-saved" data-id="<?php echo $item['MemberRecruitment']['id'];?>" href="javascript:void(0)">Xóa</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="text-center">
                                <?php if($this->params['paging']['MemberRecruitment']['pageCount'] > 1):?>
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
                            <div class="text-muted bigger-120" style="font-style: italic; margin-top: 15px">
                                Chỉ hiển thị các tin tuyển dụng còn thời hạn
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="text-center text-danger" style="padding: 25px 10px">
                                <i class="fa fa-meh-o bigger-300"></i>
                                <br>
                                <span class="bigger-150">
                                    Không có công việc đã lưu
                                </span>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="search-item-clear"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){$(".delete-saved").on("click",function(){var e=$(this).data("id");""!=e&&$.ajax({url:"/members_recruitments/delete_saved_ajax",type:"post",dataType:"json",data:{id:e},success:function(e){"success"==e.status?(alert_full("success",e.message),setTimeout(function(){window.location=window.location},1e3)):"applied"==e.status?alert_full("warning",e.message):"fail"==e.status?alert_full("error",e.message):"not_login"==e.status?alert_full("warning",e.message):window.location=window.location}})})});
</script>