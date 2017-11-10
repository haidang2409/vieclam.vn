<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <?php
            include "_menu_bar.ctp";
            ?>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 col-xs-12">
                    <h4>Thay đổi logo</h4>
                    <hr class="dotted">
                    <?php
                    echo $this->Session->flash();
                    ?>
                    <?php echo $this->Form->create('Employer', array('class' => 'form-horizontal form_has_addon', 'novalidate' => true));?>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Logo <font class="label-require">(*)</font>
                        </label>
                        <div class="col-sm-9 text-center">
                            <?php
                            $image = '/uploads/company/employer_default.jpg';
                            if($employers['Employer']['logo'] != '' && file_exists(WWW_ROOT . '/uploads/company/' . $employers['Employer']['logo']))
                            {
                                $image = '/uploads/company/' . $employers['Employer']['logo'];
                            }
                            ?>
                            <img id="company-logo" class="logo-edit" src="<?php echo $image;?>">
                            <?php echo $this->Form->input('logo', array('id' => 'logo', 'label' => false, 'class' => 'form-control', 'type' => 'hidden'));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Website <font class="label-require">(*)</font>
                        </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('website', array('id' => 'website', 'label' => false, 'class' => 'form-control', 'title' => 'Địa chỉ', 'value' => $employers['Employer']['website']));?>
                        </div>
                    </div>
                    <hr class="dotted">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Video <font class="label-require">(*)</font>
                        </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('video', array('id' => 'fullname', 'label' => false, 'class' => 'form-control', 'title' => 'Video công ty', 'value' => $employers['Employer']['video']));?>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-index" type="submit">
                            <i class="fa fa-save"></i>
                            Lưu
                        </button>
                    </div>
                    <?php
                    echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="modalChangeLogo">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 0 !important;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cập nhật logo</h4>
            </div>
            <div class="modal-body">
                <div class="image-editor">
                    <input type="file" class="cropit-image-input">
                    <br>
                    <div class="cropit-preview"></div>
                    <br>
                    <input type="range" style="width: 50%; margin: auto" class="cropit-image-zoom-input">
                </div>
                <div style="text-align: center">
                    <h4>Kéo hình ảnh để đặt lại vị trí</h4>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Hủy</button>
                <button id="btnChangeLogo" type="button" class="btn btn-success"><i class="fa fa-check"></i> Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php echo $this->Html->script('jquery.cropit');?>
<script>
    $(function () {
        $('#company-logo').click(function(){
            $('#modalChangeLogo').modal('show');
        });
        $('.cropit-image-input').ace_file_input({
            no_file:'Chọn hình ảnh ...',
            btn_choose:'Chọn hình ảnh',
            btn_change:'Thay đổi',
            droppable:false,
            onchange:null,
            thumbnail: 'large' //| true | large
        });
        $('.image-editor').cropit({
        });
        $('#btnChangeLogo').click(function () {
            var imageData = $('.image-editor').cropit('export');
            if(imageData != undefined)
            {
                $('#logo').val(imageData);
                $('#company-logo').attr("src", imageData);
                $('#modalChangeLogo').modal('hide');
            }
        })
    })
</script>