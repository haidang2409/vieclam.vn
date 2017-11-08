<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="#">Trang chủ</a>
                </li>
                <li><a href="/admin/posts">Bài viết</a> </li>
                <li>Thêm bài viết</li>
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
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Thêm bài viết
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        overview &amp; stats
                    </small>
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-12">
                    <?php echo $this->Session->flash();?>
                    <?php echo $this->Html->script('ckeditor/ckeditor');?>
                    <?php echo $this->Html->script('ckfinder/ckfinder');?>
                    <?php echo $this->Form->create('Post', array('class' => 'form-horizontal', 'method' => 'post', 'type' => 'file', 'noValidate' => true));?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Chuyên mục bài viết <font class="label-require">(*)</font> </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('post_category_id', array('type' => 'select', 'class' => 'form-control', 'label' => false, 'options' => $postcats, 'empty' => ' -- Chọn chuyên mục -- '));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tiêu đề bài viết <font class="label-require">(*)</font></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('title', array('type' => 'text', 'class' => 'form-control', 'label' => false));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tóm tắt bài viết <font class="label-require">(*)</font></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('summary', array('type' => 'textarea', 'class' => 'form-control', 'label' => false, 'rows' => 2));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nội dung bài viết <font class="label-require">(*)</font></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('description', array('type' => 'textarea', 'class' => 'form-control', 'label' => false, 'rows' => 10));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Hình ảnh bài viết</label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('image2', array('id' => 'hinh-anh', 'type' => 'file', 'class' => 'form-control', 'label' => false));?>
                        </div>
                        <div class="col-sm-9 col-sm-offset-3 col-xs-12">
                            <div class="div-hint">
                                (< 500Kb)
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-right">
                            <button onclick="window.location = '/admin/posts'; return false;" href="/admin/posts" class="btn btn-white btn-xs">
                                <i class="fa fa-ban"> </i> Hủy
                            </button>
                            <button type="submit" class="btn btn-primary btn-xs">
                                <i class="fa fa-save"></i> Lưu
                            </button>
                        </div>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<script type="text/javascript">
    $(function () {
        $('#li-post').addClass('active open');
        var editor = CKEDITOR.replace('data[Post][description]', {
            filebrowserBrowseUrl : '/app/webroot/js/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl : '/app/webroot/js/ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl : '/app/webroot/js/ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl : '/app/webroot/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl : '/app/webroot/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl : '/app/webroot/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
        });
        CKFinder.setupCKEditor(editor, '../' );
        //
        $('#hinh-anh').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false, //| true | large
            allowExt:  ['jpg', 'jpeg', 'png'],
            allowMime: ['image/jpg', 'image/jpeg', 'image/png'], //html5 browsers only
            maxSize: 500000, //~100 KB
            //blacklist:'exe|php'
            //onchange:''
            //
        });

    })
</script>
