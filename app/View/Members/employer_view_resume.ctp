<div class="background-primary">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="search-item-clear"></div>
                <div class="background-white background-padding">
                    <div class="recruitment-container recruitment-container-saved">
                        <h3>Nhà tuyển dụng đã xem hồ sơ</h3>
                        <hr>
                        <?php
                        if(isset($members_employers) && count($members_employers) > 0)
                        {
                            foreach ($members_employers as $item)
                            {
                                ?>
                                <div class="recruitment-item recruitment-item-saved">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-3 col-xs-5 image">
                                                    <a href="/nha-tuyen-dung/<?php echo $item['Employer']['id'];?>" title="<?php echo $item['Employer']['company_name'];?>">
                                                        <img src="/uploads/company/<?php echo $item['Employer']['logo'];?>">
                                                    </a>
                                                </div>
                                                <div class="div-title col-sm-9 col-xs-7">
                                                    <a href="/tim-viec-lam/nha-tuyen-dung/<?php echo $item['Employer']['company_link'];?>-<?php echo $item['Employer']['id'];?>" title="<?php echo $item['Employer']['company_name'];?>">
                                                        <h3>
                                                            <?php echo htmlentities($item['Employer']['company_name'], ENT_QUOTES, 'UTF-8');?>
                                                        </h3>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-3 col-xs-12 text-center">
                                                    <span class="bigger-120">
                                                        <?php
                                                        echo number_format($item['MemberEmployer']['view'], 0, '', '.');
                                                        ?>
                                                    </span>
                                                    <br>Lượt xem hồ sơ
                                                </div>
                                                <div class="col-sm-3 col-xs-12 text-center">
                                                    <?php
                                                    if($item['MemberEmployer']['is_saved'] == 1)
                                                    {
                                                        ?>
                                                        <i class="fa fa-check bigger-150 text-success"></i>
                                                        <br>
                                                        <span>Đã lưu hồ sơ</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-sm-3 col-xs-12 text-center">
                                                    <?php
                                                    if($item['MemberEmployer']['updated'])
                                                    {
                                                        echo '<span class="bigger-120">' . $this->Lib->convertDateTime_Mysql_to_Date($item['MemberEmployer']['updated']) . '</span>';
                                                        ?>
                                                        <br>
                                                        <span>Ngày xem mới nhất</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-sm-3 text-center" style="padding-top: 5px">
                                                    <a href="/tim-viec-lam/nha-tuyen-dung/<?php echo $item['Employer']['company_link'];?>-<?php echo $item['Employer']['id'];?>" class="btn btn-warning btn-sm tooltip-error" data-rel="tooltip" data-placement="top" title="Xem việc làm của nhà tuyển dụng" data-original-title="Top Danger">
                                                        Xem việc làm
                                                    </a>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="text-center">
                                <?php if($this->params['paging']['MemberEmployer']['pageCount'] > 1):?>
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
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="text-center text-danger">
                                <i class="fa fa-meh-o bigger-300"></i>
                                <br>
                                <span class="bigger-150">
                                    Không có nhà tuyển dụng xem hồ sơ
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
    $(function () {
        $('[data-rel=tooltip]').tooltip();
    })
</script>