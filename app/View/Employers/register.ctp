<?php
$title = 'Đăng ký tài khoản nhà tuyển dụng';
include('_header.ctp');
?>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php echo $this->Form->create('Employer', array('method' => 'post', 'novalidate' => true));?>
                <h1>Đăng ký tài khoản</h1>
                <div>
                    <?php echo $this->Form->input('company_name', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Tên công ty'));?>
                </div>
                <div>
                    <?php echo $this->Form->input('email', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Địa chỉ email'));?>
                </div>
                <div>
                    <?php echo $this->Form->input('password', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Mật khẩu'));?>
                </div>
                <div>
                    <?php echo $this->Form->input('repassword', array('label' => false, 'class' => 'form-control', 'type' => 'password', 'placeholder' => 'Nhập lại mật khẩu'));?>
                    <?php echo $this->Form->input('token', array('label' => false, 'class' => 'form-control', 'type' => 'hidden', 'value' => $this->params['_Token']['key']));?>
                </div>
                <div>
                    <div class="checkbox">
                        <label class="block">
                            <input name="form-field-checkbox" disabled="" checked class="ace" type="checkbox">
                            <span class="lbl"> Đồng ý với các <a href="/help/dieu-khoan-su-dung">điều khoản sử dụng dịch vụ</a> </span>
                        </label>
                    </div>
                </div>
                <div class="text-center-xs text-center">
                    <button class="btn btn-index" id="btnRegister">
                        <i class="fa fa-check"></i>
                        <?php echo __('Register');?>
                    </button>
                </div>
                <div class="clearfix"></div>

                <div class="separator">
                    <p class="change_link">
                        <?php echo __('Have account');?>?
                        <a href="<?php echo $_base_url_employer?>/dang-nhap"><?php echo __('Login');?></a>
                    </p>
                    <div class="clearfix"></div>
                    <br />
                    <div>
                        <h1><i class="fa fa-paw"></i> Dream Come True!</h1>
                        <p>©2016 All Rights Reserved.</p>
                    </div>
                </div>
                <?php echo $this->Form->end();?>
            </section>
        </div>
    </div>
    <script>
        $(function () {
            $('#btnRegister').click(function () {
                $(this).attr('disabled', true);
                $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
                $('#EmployerRegisterForm').submit();
            })
        })
    </script>
<?php
include('_footer.ctp');
?>
