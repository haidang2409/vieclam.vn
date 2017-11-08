<div class="main-content" id="content-post">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="/admin">Trang chủ</a>
                </li>
                <li class="active">Bài viết</li>
            </ul><!-- /.breadcrumb -->
            <div class="nav-search" id="nav-search">
                <button class="btnOpenSearch" data-show="0">
                    <i class="fa fa-search"></i>
                </button>
            </div><!-- /.nav-search -->
        </div>
        <!--            Search-->
        <div class="div-form-timkiem">
            <form class="form-horizontal" action="" method="get">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Bài viết</label>
                    <div class="col-sm-3">
                        <input type="text" name="title" class="form-control" value="<?php echo isset($this->params['url']['title'])? $this->params['url']['title']:'';?>">
                    </div>
                    <label class="col-sm-2 control-label">Chuyên mục</label>
                    <div class="col-sm-3">
                        <?php echo $this->Form->input('category', array('name' => 'category', 'type' => 'select', 'options' => $categories, 'empty' => ' -- Chọn chuyên mục - ', 'class' => 'form-control', 'label' => false, 'default' => isset($this->params['url']['category'])?$this->params['url']['category']:''));?>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-xs btn-warning"> Tìm <i class="fa fa-search"></i> </button>
                        <a href="/admin/posts" type="submit" class="btn btn-xs btn-danger"> Xóa <i class="fa fa-remove"></i> </a>
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
                            Danh sách bài viết
                            <small>
                                <i class="ace-icon fa fa-angle-double-right"></i>
                                <?php
                                echo 'Showing ' . $this->Paginator->param('current') . ' of ' . $this->Paginator->param('count');
                                ?>
                            </small>
                        </h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="/admin/posts/add" class="btn btn-xs btn btn-success">
                            Thêm <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    echo $this->Session->flash();
                    if(isset($posts) && count($posts) > 0)
                    {
                        ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Stt</th>
                                <th><?php echo $this->Paginator->sort('title', 'Tên bài viết');?></th>
                                <th>Hình ảnh</th>
                                <th>
                                    Chuyên mục
                                </th>
                                <th><?php echo $this->Paginator->sort('created', 'Ngày đăng');?></th>
                                <th><?php echo $this->Paginator->sort('created', 'Cập nhật');?></th>
                                <th>Nhân viên</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count = 0;
                            ?>
                            <?php foreach($posts as $post): ?>
                                <tr>
                                    <td style="text-align: center" width="50">
                                        <?php
                                        $paginate = $this->request->param('paging');
                                        echo ($count + 1) + (($paginate['Post']['page'] - 1) * $paginate['Post']['limit']);
                                        $count = $count + 1;
                                        ?>
                                    </td>
                                    <td style="max-width: 300px">
                                        <a href="/admin/posts/view/<?php echo $post['Post']['id'];?>">
                                            <?php echo $post['Post']['title'];?>
                                        </a>
                                    </td>
                                    <td style="max-width: 120px !important;">
                                        <?php
                                        if($post['Post']['image'] != '')
                                        {
                                            ?>
                                            <img src="/uploads/posts/<?php echo $post['Post']['image'];?>" width="100%">
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $post['PostCategory']['name'];
                                        ?>
                                    </td>
                                    <td align="center"><?php echo $this->Lib->convertDateTime_Mysql_to_Date($post['Post']['created']);?></td>
                                    <td align="center"><?php echo $this->Lib->convertDateTime_Mysql_to_Date($post['Post']['updated']);?></td>
                                    <td>
                                        <?php echo $post['Staff']['fullname'];?>
                                    </td>
                                    <td align="center">
                                        <a class="btn btn-xs btn-warning" title="Sửa" href="/admin/posts/edit/<?php echo $post['Post']['id'];?>"><i class="fa fa-pencil"></i> </a>
                                        <button type="button" data-post_id="<?php echo $post['Post']['id'];?>" data-title="<?php echo $post['Post']['title'];?>" class="btn btn-xs btn-danger btn-delete-post" title="Xóa" href=""><i class="fa fa-trash"></i> </button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
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
                        echo '<div class="alert alert-warning">Không có dữ liệu</div>';
                    }
                    ?>
                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-delete-post">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Xác nhận</h4>
            </div>
            <div class="modal-body">
                <div id="content-before">
                    <p>Xác nhận xóa bài viết: <b id="text-content"></b></p>
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
        $('#li-post').addClass('active open');
        $('#li-list-post').addClass('active');
        $('th a').append(' <i class="fa fa-sort"></i>');
        $('th a.asc i').attr('class', 'fa fa-sort-asc');
        $('th a.desc i').attr('class', 'fa fa-sort-desc');
        $('.pagination span a').on('click', function(){
            var url = this.href;
            history.pushState(null, '', url);
        });
        $('th a').on('click', function(){
            var url = this.href;
            history.pushState(null, '', url);
        });
        $(document).on('click', '.btn-delete-post',  function(){
            var post_id = $(this).data('post_id');
            var title = $(this).data('title');
            $('.modal-body #text-content').html(title);
            $('#btn-comfirm-delete').data('post_id', post_id);
            $('#modal-delete-post').modal('show');
        });
        $('#btn-comfirm-delete').click(function(){
            var post_id = $(this).data('post_id');
            if(post_id != '')
            {
                $('.modal-body #content-before').hide();
                $('.modal-body #content-after').show();
                $.ajax({
                    url: '/admin/posts/delete',
                    type: 'post',
                    dataType: 'html',
                    data: {
                        'post_id': post_id
                    },
                    success: function(st)
                    {
                        window.location = window.location;
                    }
                })
            }
        });
    })
</script>