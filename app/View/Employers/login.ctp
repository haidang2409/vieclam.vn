<?php
$title = 'Đăng nhập tài khoản nhà tuyển dụng';
include('_header.ctp');
?>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php echo $this->Form->create('Employer', array('method' => 'post', 'novalidate' => true));?>
                <h1>Đăng nhập</h1>
                <div>
                    <?php echo $this->Form->input('email', array('name' => 'email', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Địa chỉ email'));?>
                </div>
                <div>
                    <?php echo $this->Form->input('password', array('name' => 'password', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Mật khẩu'));?>
                    <?php echo $this->Form->input('token', array('name' => 'token', 'label' => false, 'class' => 'form-control', 'type' => 'hidden', 'value' => $this->params['_Token']['key']));?>
                </div>
                <div style="text-align: left; padding-top: 10px; color: #E74C3C">
                    <?php echo $this->Session->flash();?>
                </div>
                <div class="text-center-xs text-center">
                    <br>
                    <button class="btn btn-index" id="btnRegister">
                        <i class="fa fa-check"></i>
                        Đăng nhập
                    </button>
                </div>
                <div class="clearfix"></div>

                <div class="separator">
                    <p class="change_link">
                        Hoặc
                        <a href="<?php echo $_base_url_employer?>/dang-ky">Đăng ký</a>
                        | &nbsp;
                        <a href="<?php echo $_base_url_employer?>/quen-mat-khau">Quên mật khẩu</a>
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
                $('#EmployerLoginForm').submit();
            })
        })
    </script>
<?php
include('_footer.ctp');
?>
