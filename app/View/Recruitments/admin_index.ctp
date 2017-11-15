<div class="main-content" id="content-recruitment">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="/admin">Trang chủ</a>
                </li>
                <li>Tuyển dụng</li>
            </ul><!-- /.breadcrumb -->
            <div class="nav-search" id="nav-search">
                <button class="btnOpenSearch" data-show="0">
                    <i class="fa fa-search"></i>
                </button>
            </div><!-- /.nav-search -->
        </div>

        <!--        Search-->
        <div class="div-form-timkiem">
            <form class="form-horizontal" action="" method="get">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nhà tuyển dụng</label>
                    <div class="col-sm-4">
                        <?php
                        echo $this->Form->input('employer', array(
                            'type' => 'select',
                            'label' => false,
                            'style' => 'width: 100% !important',
                            'empty' => 'Tất cả',
                            'options' => $employers_option,
                            'default' => '',
                            'id' => 'employerId',
                            'name' => 'employerId'
                        ));
                        ?>
                    </div>
                    <label class="col-sm-2 control-label">Việc làm</label>
                    <div class="col-sm-4">
                        <?php
                        echo $this->Form->input('recruitment', array(
                            'type' => 'select',
                            'label' => false,
                            'style' => 'width: 100% !important',
                            'empty' => 'Tất cả',
                            'options' => $recruitments_option,
                            'default' => '',
                            'id' => 'recruitmentId',
                            'name' => 'recruitmentId'
                        ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-xs btn-warning"> Tìm <i class="fa fa-search"></i> </button>
                        <a href="/admin/recruitments" type="submit" class="btn btn-xs btn-danger"> Xóa <i class="fa fa-remove"></i> </a>
                    </div>
                </div>
            </form>
        </div>
        <!--        Search-->

        <div class="page-content">
            <div class="page-header">
                <h1>
                    Tin tuyển dụng
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?php
                        echo 'Showing ' . $this->Paginator->param('current') . ' of ' . $this->Paginator->param('count');
                        ?>
                    </small>
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">Stt</th>
                            <th><?php echo $this->Paginator->sort('Recruitment.title', 'Việc làm');?></th>
                            <th><?php echo $this->Paginator->sort('Employer.company_name', 'Nhà tuyển dụng');?></th>
                            <th class="text-center"><?php echo $this->Paginator->sort('Order.expiry', 'Hết hạn');?></th>
                            <th><?php echo $this->Paginator->sort('Recruitment.view', 'Xem');?></th>
                            <th>Ứng tuyển</th>
                        </tr>
                        </thead>
                        <?php
                        $date = getdate();
                        $arr_id_recruitment = array();
                        $cur_date = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'];
                        if(isset($jobs) && count($jobs) > 0)
                        {
                            $page = $this->request->paging['Recruitment']['page'];
                            $limit = $this->request->paging['Recruitment']['limit'];
                            $number = ($page - 1) * $limit;
                            $i = 0;
                            foreach ($jobs as $item)
                            {
                                $arr_id_recruitment[$i] = $item['Recruitment']['id'];
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <?php
                                        echo $number + ($i + 1);
                                        $i = $i + 1;
                                        ?>
                                    </td>
                                    <td>
                                        <a href="/admin/recruitments/view_detail/<?php echo $item['Recruitment']['id'];?>">
                                            <?php
                                            echo htmlentities($item['Recruitment']['title'], ENT_QUOTES, 'UTF-8');
                                            ?>
                                        </a>
                                        <div style="margin-top: 5px">
                                            <a class="orange" href="/admin/recruitments/edit/<?php echo $item['Recruitment']['id'];?>">
                                                Sửa
                                            </a>
                                            |
                                            <a href="javascript: void(0)" class="red btn-delete-job" data-id="<?php echo $item['Recruitment']['id'];?>">
                                                Xóa
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="/admin/employers/view_detail/<?php echo $item['Employer']['id'];?>">
                                            <?php
                                            echo htmlentities($item['Employer']['company_name'], ENT_QUOTES, 'UTF-8');
                                            ?>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <?php
                                        if($item['Order']['expiry'])
                                        {
                                            echo $this->Lib->convertDateTime_Mysql_to_Date($item['Order']['expiry']);
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
                        }
                        else
                        {
                            ?>
                            <tr>
                                <td colspan="6" align="center">
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
                            <?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
                            <?php echo $this->Paginator->numbers(array('class' => 'numbers'));?>
                            <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
                        </div>
                        <?php
                    }
                    ?>
                    <!--                    End pagination-->
                </div>
            </div>
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<script>
    $(function () {
        $('#li-recruitment').addClass('active open');
        $('#li-list-recruitment').addClass('active');
        var arr_recruitment = [<?php echo implode($arr_id_recruitment, ',');?>];
        $.ajax({
            url: '/recruitments/get_count_apply',
            type: 'post',
            dataType: 'json',
            data: {
                'arr_recruitment': arr_recruitment
            },
            success: function(data) {
                var i = 0;
                var sum = data.length;
                for (i = 0; i < sum; i++) {
                    $('.sum-applied-' + data[i]['recruitment']).html(data[i]['sum']);
                }
            }
        });
    });
</script>