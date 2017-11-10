<div class="container" style="min-height: 500px">
    <div class="row">
        <div class="col-sm-12">
            <div class="row" style="margin-bottom: 20px">
                <div class="col-sm-8">
                    <?php
                    $status = isset($this->params['status'])? $this->params['status']: '';
                    ?>
                    <a class="a-job-status <?php if($status == '') { echo 'active';}?>" href="<?php echo $_base_url_employer;?>/viec-lam">
                        Đang hiển thị
                    </a>
                    <a class="a-job-status <?php if($status == 'draft') { echo 'active';}?>"  href="<?php echo $_base_url_employer;?>/viec-lam/tin-nhap">
                        Tin nháp
                    </a>
                    <a class="a-job-status <?php if($status == 'hidden') { echo 'active';}?>"  href="<?php echo $_base_url_employer;?>/viec-lam/dang-an">
                        Đang ẩn
                    </a>
                    <a class="a-job-status <?php if($status == 'expried') { echo 'active';}?>"  href="<?php echo $_base_url_employer;?>/viec-lam/het-han">
                        Hết hạn
                    </a>
                </div>
                <div class="col-sm-4 text-right bigger-130">
                    <?php echo number_format($this->Paginator->param('count'), 0, '', '.');?> việc làm
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table">
                        <tr>
                            <td class="bolder">Việc làm</td>
                            <td class="text-center bolder">Hết hạn</td>
                            <td class="text-center bolder">Xem</td>
                            <td class="text-center bolder">Ứng tuyển</td>
                        </tr>
                        <?php
                        $date = getdate();
                        $cur_date = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'];
                        if(isset($jobs) && count($jobs) > 0)
                        {
                            foreach ($jobs as $item)
                            {
                                ?>
                                <tr>
                                    <td>
                                        <a class="a-index" href="<?php echo $_base_url_employer;?>/ho-so-ung-vien/?recruitmentId=<?php echo $item['Recruitment']['id'];?>">
                                            <?php
                                            echo htmlentities($item['Recruitment']['title'], ENT_QUOTES, 'UTF-8');
                                            ?>
                                        </a>
                                        <span class="list-job-action">
                                            <a href="<?php echo $_base_url_employer;?>/sua-viec-lam/<?php echo $item['Recruitment']['id'];?>">
                                                Sửa
                                            </a>
                                            |
                                            <a href="<?php echo $_base_url_employer;?>/viec-lam/sua/<?php echo $item['Recruitment']['id'];?>">
                                                Sao chép
                                            </a>
                                            |
                                            <a href="javascript: void(0)" class="btn-delete-job" data-id="<?php echo $item['Recruitment']['id'];?>">
                                                Xóa
                                            </a>
                                        </span>
                                    </td>
                                    <td align="center" valign="middle">
                                        <?php
                                        if($item['Order']['expiry'])
                                        {
                                            $expiry = new DateTime($item['Order']['expiry']);
                                            $date_now = new DateTime($cur_date);
                                            $interval = $expiry->diff($date_now);
                                            $per_expiry = round(($interval->days / 30) * 100);
                                            echo $this->Lib->convertDateTime_Mysql_to_Date($item['Order']['expiry']);
                                            ?>
                                            <span class="span-expiry">
                                                <?php
                                                if($expiry > $date_now)
                                                {
                                                    ?>
                                                    <div class="count-expiry" style="width: <?php echo $per_expiry?>% !important;"></div>
                                                    <?php
                                                }
                                                ?>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td align="center"  valign="middle">
                                        <?php
                                        echo $item['Recruitment']['view'];
                                        ?>
                                    </td>
                                    <td align="center"  valign="middle">
                                        <span class="sum-apply sum-applied-<?php echo $item['Recruitment']['id'];?>">
                                            <i class="fa fa-spin fa-spinner"></i>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr class="tr-note">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td align="center">
                                    Đã xem/tất cả
                                </td>
                            </tr>
                            <?php
                        }
                        else
                        {
                            ?>
                            <tr>
                                <td colspan="4" align="center">
                                    <p style="font-size: 1.2em; font-style: italic">
                                        Không có việc làm
                                    </p>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
<!--                    Pagination-->
                    <?php
                    if($this->params['paging']['Recruitment']['pageCount'] > 1)
                    {
                        ?>
                        <div class="pagination">
                            <?php echo $this->Paginator->numbers(array(
                                'separator' => '',
                                'currentTag' => 'a',
                                'currentClass' => 'active',
                                'ellipsis'=>'<a>...</a>',
                                'modulus' => 4,
                                'first' => 2,
                                'last' => 2
                            ));
                            ?>
                        </div>
                        <?php
                    }
                    ?>
<!--                    End pagination-->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalDeleteJob">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Xác nhận xóa</h4>
            </div>
            <div class="modal-body text-center">
                <div id="content-before">
                    <div class="circle-confirm">
                        <div class="circle-confirm-top"></div>
                        <div class="circle-confirm-bottom"></div>
                    </div>
                </div>
                <div id="content-after" style="display: none">
                    <div class="circle-loader">
                        <div class="checkmark draw"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy <i class="fa fa-ban"></i></button>
                <button id="btnConfirmDelete" type="button" class="btn btn-primary"> Xóa <i class="fa fa-trash"></i> </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(function () {
        $.getJSON('/employers/get_count_apply', function(data){
            var i = 0;
            var sum = data.length;
            for(i = 0; i< sum; i++)
            {
                $('.sum-applied-' + data[i]['recruitment']).html('<a href="/nha-tuyen-dung/ho-so-ung-vien?recruitmentId=' + data[i]['recruitment'] + '" class="a-index" title="Đã xem ' + data[i]['viewed'] + '/' + data[i]['sum'] + ' hồ sơ">' + data[i]['viewed'] + '/' + data[i]['sum'] + '</a>');
            }
        });
        $('.btn-delete-job').on('click', function () {
            $('#modalDeleteJob').modal('show');
        });
        $('#btnConfirmDelete').click(function () {
            $('#content-before').hide();
            $('#content-after').show();
            setTimeout(function () {
                $('.circle-loader').toggleClass('load-complete');
                $('.checkmark').toggle();
            }, 1000);
        });
    })
</script>