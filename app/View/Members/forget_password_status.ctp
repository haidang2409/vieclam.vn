<div  style="background-color: #ededed; margin-top: -20px; margin-bottom: -20px; min-height: 430px">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <?php echo $this->Form->create('Member', array('id' => 'frmLogin', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));?>
                        <?php
                        if($status == 'sent_email')
                        {
                            ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="red" style="padding-top: 10px">
                                        Hệ thống vừa gửi cho bạn email để đặt lại mật khẩu.
                                        Vui lòng kiểm tra lại email, nếu không tìm thấy trong Inbox vui lòng kiểm tra trong hộp thư Spam.
                                    </div>
                                </div>

                            </div>
                            <?php
                        }
                        else if($status == 'success')
                        {
                            ?>
                            <div class="form-group">
                                <div class="col-sm-12 text-center">
                                    <div class="green" style="padding-top: 10px">
                                        Mật khẩu đã được thay đổi
                                    </div>
                                </div>

                            </div>
                            <div class="text-center-xs text-center" style="margin: 10px auto">
                                <a href="/dang-nhap" class="btn btn-index" id="btnRegister" style="border-radius: 3px !important;">
                                    Đăng nhập
                                </a>
                            </div>
                            <?php
                        }
                        else if($status == 'fail')
                        {
                            ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="red" style="padding-top: 10px">
                                        Đường dẫn không chính xác. Vui lòng kiểm tra lại.
                                    </div>
                                </div>

                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="red" style="padding-top: 10px">

                                    </div>
                                </div>

                            </div>
                            <div class="text-center-xs text-center" style="margin: 10px auto">
                                <button class="btn btn-index" id="btnRegister">
                                    <i class="fa fa-send"></i>
                                    Gửi
                                </button>
                            </div>
                            <?php
                        }
                        ?>
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
