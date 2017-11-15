<div  style="background-color: #ededed; margin-top: -20px; margin-bottom: -20px; min-height: 430px">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <?php echo $this->Form->create('Member', array('id' => 'frmLogin', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));?>
                        <div class="text-center div-img">
                            <h3>Quên mật khẩu</h3>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                Nhập địa chỉ email bạn đã đăng ký, chúng tôi sẽ gửi hướng dẫn thay đổi mật khẩu vào email cho bạn.
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $this->Form->input('email', array('name' => 'email', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Địa chỉ email', 'type' => 'text'));?>
                                <div class="red" style="padding-top: 10px">
                                    <?php
                                    echo $this->Session->flash();
                                    ?>
                                </div>
                            </div>

                        </div>
                        <div class="text-center-xs text-center" style="margin: 10px auto">
                            <button class="btn btn-index" id="btnRegister">
                                <i class="fa fa-send"></i>
                                Gửi
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
//        $('#btnRegister').click(function () {
//            $(this).attr('disabled', true);
//            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
//            $('#frmLogin').submit();
//        })
    })
</script>
