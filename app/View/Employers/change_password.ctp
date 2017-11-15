<div class="container" style="min-height: 450px">
    <div class="row">
        <div class="col-sm-3">
            <?php
            include "_menu_bar.ctp";
            ?>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 col-xs-12">
                    <h4>Thay đổi mật khẩu</h4>
                    <hr class="dotted">
                    <?php
                    echo $this->Session->flash();
                    ?>
                    <?php echo $this->Form->create('Employer', array('class' => 'form-horizontal form_has_addon', 'novalidate' => true));?>
                    <div class="form-group">

                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Mật khẩu hiện tại <font class="label-require">(*)</font>
                        </label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->input('password_old', array('type' => 'password', 'id' => 'old_password', 'label' => false, 'class' => 'form-control', 'title' => 'Mật khẩu hiện tại'));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Mật khẩu mới <font class="label-require">(*)</font>
                        </label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->input('password_new', array('type' => 'password', 'id' => 'new_password', 'label' => false, 'class' => 'form-control', 'title' => 'Nhập mật khẩu mới'));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Nhập lại mật khẩu mới <font class="label-require">(*)</font>
                        </label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->input('re_password_new', array('type' => 'password', 'id' => 're_new_password', 'label' => false, 'class' => 'form-control', 'title' => 'Nhập lại mật khẩu mới'));?>
                        </div>
                    </div>
                    <div class="text-right form-group">
                        <div class="col-sm-11">
                            <button class="btn btn-index" type="submit">
                                <i class="fa fa-check"></i>
                                Xác nhận
                            </button>
                        </div>

                    </div>
                    <?php
                    echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>