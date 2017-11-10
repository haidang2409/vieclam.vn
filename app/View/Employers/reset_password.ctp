<?php
$title = 'Đặt lại mật khẩu';
include('_header.ctp');
?>
<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
            <?php echo $this->Form->create('Employer', array('method' => 'post', 'novalidate' => true));?>
            <h1>Đặt lại mật khẩu</h1>
            <div>
                <?php echo $this->Form->input('password_new', array('name' => 'password_new', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Mật khẩu mới', 'type' => 'password'));?>
            </div>
            <div>
                <?php echo $this->Form->input('re_password_new', array('name' => 're_password_new', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Nhập lại mật khẩu', 'type' => 'password'));?>
            </div>
            <div style="text-align: left; padding-top: 10px; color: #E74C3C">
                <?php echo $this->Session->flash();?>
            </div>
            <div class="text-center-xs text-center">
                <br>
                <button class="btn btn-index" id="btnRegister">
                    <i class="fa fa-check"></i>
                    Xác nhận
                </button>
            </div>
            <div class="clearfix"></div>

            <div class="separator">
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
