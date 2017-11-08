<div class="main-content" id="content-order">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="/admin">Trang chủ</a>
                </li>
                <li><a href="/admin/orders">Hóa đơn</a> </li>
                <li>Danh sách hóa đơn</li>
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
                    <label class="col-sm-2 control-label">Nhà tuyển dụng</label>
                    <div class="col-sm-4">
                        <input placeholder="Nhập email hoặc tên đăng nhập" type="text" name="name" class="form-control" value="<?php echo isset($this->params['url']['name'])? $this->params['url']['name']:'';?>">
                    </div>
                    <label class="col-sm-2 control-label">Loại</label>
                    <div class="col-sm-4">
                        <?php echo $this->Form->input('packet', array('name' => 'packet', 'type' => 'select', 'label' => false, 'options' => $packets, 'class' => 'form-control', 'empty' => ' -- Tất cả -- ', 'default' => $packet_id));?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Trạng thái</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="status">
                            <option value=""> -- Tất cả -- </option>
                            <option value="1" <?php if($status == '1') { echo 'selected';}?>>Đã duyệt</option>
                            <option value="0" <?php if($status == '0') { echo 'selected';}?>>Chưa duyệt</option>
                        </select>
                    </div>
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-4 text-right">
                        <button class="btn btn-warning btn-xs" type="submit"><i class="fa fa-search"></i>  Tìm </button>
                        <a href="/admin/orders" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i>  Xóa </a>
                    </div>
                </div>
            </form>
        </div>
<!--        End form search-->
        <div class="page-content">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>
                            Hóa đơn
                            <small>
                                <i class="ace-icon fa fa-angle-double-right"></i>
                                <?php
                                echo 'Showing ' . $this->Paginator->param('current') . ' of ' . $this->Paginator->param('count');
                                ?>
                            </small>
                        </h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="/admin/orders/add" class="btn btn-xs btn btn-success">
                            Thêm <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    echo $this->Session->flash();
                    if(isset($orders) && count($orders) > 0)
                    {
                        ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Stt</th>
                                <th><?php echo $this->Paginator->sort('Recruitment.title', 'Tin đăng');?></th>
                                <th>Nhà tuyển dụng</th>
                                <th><?php echo $this->Paginator->sort('Packet.packetname', 'Loại tin');?></th>
                                <th><?php echo $this->Paginator->sort('Order.created', 'Ngày tạo');?></th>
                                <th>
                                    <?php echo $this->Paginator->sort('Order.sumamount', 'Tổng tiền');?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('Order.discount', 'Giảm giá');?>
                                </th>
                                <th>Nhân viên duyệt</th>
                                <th>Đã duyệt</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count = 0;
                            ?>
                            <?php foreach($orders as $order): ?>
                                <tr>
                                    <td style="text-align: center" width="50">
                                        <?php
                                        $paginate = $this->request->param('paging');
                                        echo ($count + 1) + (($paginate['Order']['page'] - 1) * $paginate['Order']['limit']);
                                        $count = $count + 1;
                                        ?>
                                    </td>
                                    <td style="max-width: 300px">
                                        <a href="/admin/recruitment/view_detail/<?php echo $order['Recruitment']['id'];?>">
                                            <?php echo htmlentities($order['Recruitment']['title'], ENT_QUOTES, 'UTF-8');?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/admin/employers/view_detail/<?php echo $order['Employer']['id'];?>">
                                            <?php echo htmlentities($order['Employer']['company_name'], ENT_QUOTES, 'UTF-8');?>
                                        </a>
                                    </td>
                                    <td><?php echo $order['Packet']['packet_name'];?></td>
                                    <td align="center"><?php echo $this->Lib->convertDateTime_Mysql_to_Date($order['Order']['created']);?></td>
                                    <td align="right"><?php echo number_format($order['Order']['sumamount'], 0, '', '.');?></td>
                                    <td align="right"><?php echo $order['Order']['discount'];?></td>
                                    <td><?php echo $order['Staff']['fullname'];?></td>
                                    <td align="center">
                                        <?php
                                        if($order['Order']['status'] == 1)
                                        {
                                            echo '<i class="green fa fa-check"></i>';
                                        }
                                        ?>
                                    </td>
                                    <td align="center">
                                        <a class="btn btn-xs btn-warning" title="Sửa" href="/admin/orders/edit/<?php echo $order['Order']['id'];?>"><i class="fa fa-pencil"></i> </a>
                                        <button type="button" data-category_id="<?php echo $order['Order']['id'];?>" class="btn btn-xs btn-danger btn-delete-order" title="Xóa" href=""><i class="fa fa-trash"></i> </button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" align="right">
                                        <?php echo number_format($total['total'], 0, '', '.');?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="pagination">
                            <?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
                            <?php echo $this->Paginator->numbers(array(
                                'class' => 'numbers',
                            ));?>
                            <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
                        </div>
                        <?php
                    }
                    else
                    {
                        echo '<div class="alert alert-warning">Không có hóa đơn</div>';
                    }
                    ?>
                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalDeleteOrder">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Xác nhận</h4>
            </div>
            <div class="modal-body">
                <div id="content-before">
                    <p>Xác nhận xóa loại bất động sản: <b id="text-content"></b></p>
                </div>
                <div id="content-after" class="text-center" style="display: none; color: #ec971f; font-size: 2em">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy <i class="fa fa-ban"></i></button>
                <button id="btn-comfirm-delete" type="button" class="btn btn-primary"> Xóa <i class="fa fa-trash"></i> </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--End modal-->
<script>
    $(function () {
        $('th a').append(' <i class="fa fa-sort"></i>');
        $('th a.asc i').attr('class', 'fa fa-sort-asc');
        $('th a.desc i').attr('class', 'fa fa-sort-desc');
        $(document).on('click', '.btn-delete-category',  function(){
            var category_id = $(this).data('category_id');
            var categoryname = $(this).data('categoryname');
            $('.modal-body #text-content').html(categoryname);
            $('#btn-comfirm-delete').data('category_id', category_id);
            $('#modal-delete-category').modal('show');
        });
        $('#btn-comfirm-delete').click(function(){
            var category_id = $(this).data('category_id');
            if(category_id != '')
            {
                $('.modal-body #content-before').hide();
                $('.modal-body #content-after').show();
                $.ajax({
                    url: '/admin/categories/delete',
                    type: 'post',
                    dataType: 'html',
                    data: {
                        'category_id': category_id
                    },
                    success: function(st)
                    {
                        window.location = window.location;
                    }
                })
            }
        });
        $('#li-order').addClass('active open');
        $('#li-list-order').addClass('active');
    })
</script>