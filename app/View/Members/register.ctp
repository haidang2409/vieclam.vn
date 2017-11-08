<div  style="background-color: #ededed; margin-top: -20px; margin-bottom: -20px">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <?php echo $this->Form->create('Member', array('id' => 'frmRegister', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));?>
<!--                        <h3>Đăng ký thành viên</h3>-->
                        <div class="text-center div-img">
                            <img src="/img/logo_primary.png" width="200px">
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $this->Form->input('email', array('id' => 'email', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Địa chỉ email', 'type' => 'text'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $this->Form->input('fullname', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Họ tên', 'type' => 'text'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $this->Form->input('password', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Mật khẩu'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $this->Form->input('repassword', array('label' => false, 'class' => 'form-control', 'type' => 'password', 'placeholder' => 'Nhập lại mật khẩu'));?>
                                <?php echo $this->Form->input('token', array('label' => false, 'class' => 'form-control', 'type' => 'hidden', 'value' => $this->params['_Token']['key']));?>
                            </div>
                        </div>
                        <div>
                            <div class="checkbox">
                                <label class="block">
                                    <input name="form-field-checkbox" disabled="" checked class="ace" type="checkbox">
                                    <span class="lbl"> Đồng ý với các <a href="/help/dieu-khoan-su-dung">điều khoản sử dụng dịch vụ</a> </span>
                                </label>
                            </div>
                        </div>
                        <div class="text-center-xs text-center" style="margin: 10px auto">
                            <button class="btn btn-default" type="reset">
                                <i class="fa fa-refresh"></i>
                                <?php echo __('Reset');?>
                            </button>
                            <button class="btn btn-index" id="btnRegister">
                                <i class="fa fa-check"></i>
                                <?php echo __('Register');?>
                            </button>
                        </div>
                        <div class="clearfix"></div>

                        <div class="separator text-center">
                            <p class="change_link">
                                <?php echo __('Have account');?>?
                                <a href="/members/login"><?php echo __('Login');?></a>
                            </p>
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
            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading')
            $('#frmRegister').submit();
        });
        $('#email').blur(function () {
            var email = $(this).val();
            if(email != '')
            {
                $.ajax({
                    url: '/members/check_email',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        email: email
                    },
                    success: function (data) {
                        if(data.status == 'exist')
                        {
                            $('#email').after('<div id="check_email" class="error-message">Địa chỉ email này đã đăng ký tài khoản rồi</div>');
                        }
                        else
                        {
                            $('#check_email').hide();
                        }
                    }
                })
            }
        });
    })
</script>
