<div  style="background-color: #ededed; margin-top: -20px; margin-bottom: -20px; min-height: 430px">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <?php echo $this->Form->create('Member', array('id' => 'frmLogin', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));?>
<!--                        <h3>Đăng nhập</h3>-->
                        <div class="text-center div-img">
                            <img src="/img/logo_primary.png" width="200px">
                        </div>
                        <div>
                            <?php
                            echo $this->Session->flash();
                            ?>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $this->Form->input('email', array('name' => 'email', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Địa chỉ email', 'type' => 'text'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $this->Form->input('password', array('name' => 'password', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Mật khẩu'));?>
                                <?php echo $this->Form->input('token', array('label' => false, 'class' => 'form-control', 'type' => 'hidden', 'value' => $this->params['_Token']['key']));?>
                                <input type="hidden" name="redirect" value="<?php echo isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']: '/';?>">
                            </div>
                        </div>
                        <div class="text-center-xs text-center" style="margin: 10px auto">
                            <button class="btn btn-index" id="btnRegister">
                                <i class="fa fa-check"></i>
                                <?php echo __('Login');?>
                            </button>
                        </div>
                        <div class="clearfix"></div>

                        <div class="separator text-center">
                            <p class="change_link">
                                Chưa có tài khoản?
                                <a href="/dang-ky"><?php echo __('Register');?></a>
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
            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
            $('#frmLogin').submit();
        })
    })
</script>
