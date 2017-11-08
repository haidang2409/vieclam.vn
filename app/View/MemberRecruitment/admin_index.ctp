<div class="main-content" id="content-post">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="/admin">Trang chủ</a>
                </li>
                <li class="active">Danh sách ứng tuyển</li>
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
                        <a href="/admin/members" type="submit" class="btn btn-xs btn-danger"> Xóa <i class="fa fa-remove"></i> </a>
                    </div>
                </div>
            </form>
        </div>
<!--        Search-->
        <div class="page-content">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>
                            Danh sách ứng tuyển
                            <small>
                                <i class="ace-icon fa fa-angle-double-right"></i>
                                <?php
                                echo 'Showing ' . $this->Paginator->param('current') . ' of ' . $this->Paginator->param('count');
                                ?>
                            </small>
                        </h1>
                    </div>
                    <div class="col-sm-6 text-right">
                    </div>
                </div>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td class="text-center">
                                <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" class="ace" type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </td>
                            <td class="bolder">Ứng viên</td>
                            <td class="bolder">Việc làm</td>
                            <td class="bolder text-center">Ngày ứng tuyển</td>
                            <td class="bolder">Trạng thái</td>
                            <td class="bolder text-center">Đã lưu</td>
                            <td class="bolder text-center">Thao tác</td>
                        </tr>
                        </thead>
                        <?php
                        if(isset($candidates) && count($candidates) > 0)
                        {
                            foreach ($candidates as $item)
                            {
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="checkbox">
                                            <label>
                                                <input name="form-field-checkbox" class="ace" type="checkbox">
                                                <span class="lbl"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="bolder" href="/admin/members/view_detail/<?php echo $item['Member']['id'];?>">
                                            <?php echo htmlentities($item['Member']['fullname'], ENT_QUOTES, 'UTF-8');?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/admin/recruitments/view_detail/<?php $item['Recruitment']['id'];?>">
                                            <?php
                                            echo htmlentities($item['Recruitment']['title'], ENT_QUOTES, 'UTF-8');
                                            ?>
                                        </a>
                                    </td>
                                    <td class="center">
                                        <?php
                                        echo $this->Lib->convertDateTime_Mysql_to_Date($item['MemberRecruitment']['date_applied']);
                                        ?>
                                    </td>
                                    <td>

                                    </td>
                                    <td class="text-center">

                                    </td>
                                    <td class="text-center">
                                        <div class="">
                                            <div class="inline pos-rel">
                                                <a class="btn btn-xs btn-info" title="Xem hồ sơ" href="<?php echo $_base_url_employer?>/ho-so-ung-vien/<?php echo $item['MemberRecruitment']['id'];?>">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                                <button title="Thay đổi trạng thái" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                    <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-status dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                    <?php
                                                    if(isset($status) && count($status) > 0)
                                                    {
                                                        foreach ($status as $st)
                                                        {
                                                            ?>
                                                            <li>
                                                                <a href="javascript: void(0)" data-memberRecruitmentId="<?php echo $item['MemberRecruitment']['id'];?>" data-recruitmentStatusId="<?php echo $st['RecruitmentStatus']['id'];?>" class="btn-change-status tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                                    <i class="fa fa-circle-thin <?php echo $st['RecruitmentStatus']['color'];?>"></i>
                                                                    <?php echo $st['RecruitmentStatus']['status_name'];?>
                                                                </a>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <p style="font-size: 1.2em; font-style: italic">
                                        Không có ứng viên
                                    </p>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <div class="pagination">
                        <?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
                        <?php echo $this->Paginator->numbers(array(
                            'class' => 'numbers',
                        ));?>
                        <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
                    </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<!--End modal-->
<script>
    $(function () {
        $('#li-member').addClass('active open');
        $('#li-candidate').addClass('active');
        $('#recruitmentId').select2({

        });
        $('#employerId').select2({

        });
    })
</script>