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
                    <h4>Thay đổi email</h4>
                    <hr class="dotted">
                    <div class="red text-center" style="padding-top: 15px; padding-bottom: 15px">
                        <?php
                        echo $this->Session->flash();
                        ?>
                    </div>
                    <?php echo $this->Form->create('Employer', array('class' => 'form-horizontal form_has_addon', 'novalidate' => true));?>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Mật khẩu hiện tại <font class="label-require">(*)</font>
                        </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('password', array('id' => 'password', 'label' => false, 'class' => 'form-control'));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Địa chỉ email mới <font class="label-require">(*)</font>
                        </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('email', array('id' => 'email', 'label' => false, 'class' => 'form-control'));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-right">
                            <button class="btn btn-index" type="submit">
                                <i class="fa fa-save"></i>
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
<!--Modal-->
<script>

</script>