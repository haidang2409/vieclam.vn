<div  style="background-color: #ededed; margin-top: -20px; margin-bottom: -20px; min-height: 430px">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <?php echo $this->Form->create('Member', array('id' => 'frmLogin', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));?>
                        <h3 class="text-center">Đặt lại mật khẩu</h3>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $this->Form->input('password_new', array('type' => 'password', 'name' => 'password_new', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Nhập mật khẩu mới'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $this->Form->input('re_password_new', array('type' => 'password', 'name' => 're_password_new', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Nhập lại mật khẩu'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 red">
                                <?php echo $this->Session->flash();?>
                            </div>
                        </div>
                        <div class="text-center-xs text-center" style="margin: 10px auto">
                            <button class="btn btn-index" id="btnRegister">
                                <i class="fa fa-check"></i>
                                Xác nhận
                            </button>
                        </div>
                        <div class="clearfix"></div>

                        <div class="separator text-center">
                            <div class="clearfix"></div>
                        </div>
                        <?php echo $this->Form->end();?>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(function () {
        $('#btnRegister').click(function () {
            $(this).attr('disabled', true);
            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
            $('#frmLogin').submit();
        })
    })
</script>
