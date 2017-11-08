<div class="main-content" id="content-employer">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="/admin">Trang chủ</a>
                </li>
                <li class="active">Nhà tuyển dụng</li>
            </ul><!-- /.breadcrumb -->
            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon">
                        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div><!-- /.nav-search -->
        </div>
        <!--            Search-->
        <div class="div-form-timkiem">
            <form class="form-horizontal" action="" method="get">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email/Tên đăng nhập</label>
                    <div class="col-sm-4">
                        <input placeholder="Nhập email hoặc họ tên" type="text" name="name" class="form-control" value="">
                    </div>
                    <div class="col-sm-6 text-right">
                        <button type="submit" class="btn btn-xs btn-warning"> Tìm <i class="fa fa-search"></i> </button>
                        <a href="/admin/employers" type="submit" class="btn btn-xs btn-danger"> Xóa <i class="fa fa-remove"></i> </a>
                    </div>
                </div>
            </form>
        </div>
        <!--        End form search-->
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Nhà tuyển dụng
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?php
                        echo 'Showing ' . $this->Paginator->param('current') . ' of ' . $this->Paginator->param('count');
                        ?>
                    </small>
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-12 div-has-table">
                    <?php
                    echo $this->Session->flash();
                    if(isset($employers) && count($employers) > 0)
                    {
                        ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Stt</th>
                                <th><?php echo $this->Paginator->sort('Employer.company_name', 'Nhà tuyển dụng');?></th>
                                <th><?php echo $this->Paginator->sort('Employer.email', 'Email');?></th>
                                <th><?php echo $this->Paginator->sort('Employer.phone', 'Điện thoại');?></th>
                                <th><?php echo $this->Paginator->sort('Employer.province_id', 'Tỉnh thành');?></th>
                                <th><?php echo $this->Paginator->sort('Employer.scale_id', 'Quy mô');?></th>
                                <th><?php echo $this->Paginator->sort('Employer.status', 'Active');?></th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count = 0;
                            ?>
                            <?php foreach($employers as $item): ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo $count + 1;
                                        $count = $count + 1;
                                        ?>
                                    </td>
                                    <td>
                                        <a class="bolder" href="/admin/employers/view_detail/<?php echo $item['Employer']['id']; ?>">
                                            <?php echo htmlentities($item['Employer']['company_name'], ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </td>
                                    <td><?php echo $item['Employer']['email']; ?></td>
                                    <td align="center">
                                        <?php
                                        echo $item['Employer']['phone'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $item['Province']['provincename']; ?>
                                    </td>
                                    <td>
                                        <?php echo $item['Scale']['scale_name'];?>
                                    </td>
                                    <td align="center">
                                        <?php echo $item['Employer']['status'] == 1? '<i class="fa fa-check green"></i>': ''; ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        if($item['Employer']['status'] == 1)
                                        {
                                            ?>
                                            <button data-employer_id="<?php echo $item['Employer']['id'];?>" data-company_name="<?php echo htmlentities($item['Employer']['company_name'], ENT_QUOTES, 'UTF-8');?>" class="btn btn-warning btn-xs btn-disactive-member" title="Khóa tài khoản">
                                                <i class="fa fa-lock"></i>
                                            </button>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <button data-employer_id="<?php echo $item['Employer']['id'];?>" data-company_name="<?php echo htmlentities($item['Employer']['company_name'], ENT_QUOTES, 'UTF-8');?>" class="btn btn-success btn-xs btn-active-member" title="Kích hoạt tài khoản">
                                                <i class="fa fa-unlock"></i>
                                            </button>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="pagination">
                            <?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
                            <?php echo $this->Paginator->numbers(array('class' => 'numbers'));?>
                            <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
                        </div>
                        <?php
                    }
                    else
                    {
                        echo '<div class="alert alert-warning">Không có nhà tuyển dụng</div>';
                    }
                    ?>

                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-disactive-member">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Xác nhận</h4>
            </div>
            <div class="modal-body">
                <div id="content-before">
                    <p>Xác nhận khóa tài khoản: <b id="text-content"></b></p>
                </div>
                <div id="content-after" class="text-center" style="display: none; color: #ec971f; font-size: 2em">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"> Hủy <i class="fa fa-ban"></i></button>
                <button id="btn-comfirm-delete" type="button" class="btn btn-xs btn-primary"> Khóa <i class="fa fa-lock"></i> </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-active-member">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Xác nhận</h4>
            </div>
            <div class="modal-body">
                <div id="content-before">
                    <p>Xác nhận mở khóa tài khoản: <b id="text-content"></b></p>
                </div>
                <div id="content-after" class="text-center" style="display: none; color: #ec971f; font-size: 2em">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"> Hủy <i class="fa fa-ban"></i></button>
                <button id="btn-comfirm-active" type="button" class="btn btn-xs btn-primary"> Mở khóa <i class="fa fa-unlock"></i> </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--End modal-->
<script>
    $(function () {
        $('#li-employer').addClass('active open');
        $('#li-list-employer').addClass('active');

//
//        $(document).on('click', '.btn-disactive-member',  function(){
//            var member_id = $(this).data('member_id');
//            var fullname = $(this).data('fullname');
//            $('.modal-body #text-content').html(fullname);
//            $('#btn-comfirm-delete').data('member_id', member_id);
//            $('#modal-disactive-member').modal('show');
//        });
//        $('#btn-comfirm-delete').click(function(){
//            var member_id = $(this).data('member_id');
//            if(member_id != '')
//            {
//                $('.modal-body #content-before').hide();
//                $('.modal-body #content-after').show();
//                $.ajax({
//                    url: '/admin/members/disactive',
//                    type: 'post',
//                    dataType: 'html',
//                    data: {
//                        'member_id': member_id
//                    },
//                    success: function(st)
//                    {
//                        window.location = window.location;
//                    }
//                })
//            }
//        });
//        $(document).on('click', '.btn-active-member',  function(){
//            var member_id = $(this).data('member_id');
//            var fullname = $(this).data('fullname');
//            $('.modal-body #text-content').html(fullname);
//            $('#btn-comfirm-active').data('member_id', member_id);
//            $('#modal-active-member').modal('show');
//        });
//        $('#btn-comfirm-active').click(function(){
//            var member_id = $(this).data('member_id');
//            if(member_id != '')
//            {
//                $('.modal-body #content-before').hide();
//                $('.modal-body #content-after').show();
//                $.ajax({
//                    url: '/admin/members/active',
//                    type: 'post',
//                    dataType: 'html',
//                    data: {
//                        'member_id': member_id
//                    },
//                    success: function(st)
//                    {
//                        window.location = window.location;
//                    }
//                })
//            }
//        });
    })
</script>