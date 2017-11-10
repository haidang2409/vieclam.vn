<?php
$title = 'Đặt lại mật khẩu';
include('_header.ctp');
?>
<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
            <?php
            if($status == 'fail')
            {
                ?>
                <?php echo $this->Form->create('Employer', array('method' => 'post', 'novalidate' => true));?>
                <h1>Lỗi</h1>
                <div>
                    Đường dẫn không chính xác, vui lòng kiểm tra lại.
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
                <?php
            }
            else if($status == 'success')
            {
                ?>
                <?php echo $this->Form->create('Employer', array('method' => 'post', 'novalidate' => true));?>
                <h1>Đã đổi mật khẩu</h1>
                <div>
                    Mật khẩu của bạn đã được thay đổi.
                    <br>
                    <a class="btn btn-index" href="/nha-tuyen-dung/dang-nhap" style="text-decoration: none !important;">Đăng nhập</a>
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
                <?php
            }
            else if($status == 'sent_email')
            {
                ?>
                <?php echo $this->Form->create('Employer', array('method' => 'post', 'novalidate' => true));?>
                <h1>Đã gửi email</h1>
                <div>
                    Hệ thống vừa gửi cho bạn email để đặt lại mật khẩu, vui lòng kiểm tra lại email của bạn.
                    Nếu không tìm thấy email trong Inbox vui lòng kiểm tra lại hộp thư Spam
                    <br>
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
                <?php
            }
            else
            {
                ?>
                <?php echo $this->Form->create('Employer', array('method' => 'post', 'novalidate' => true));?>
                <h1>Lỗi</h1>
                <div>

                    <br>
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
                <?php
            }
            ?>
        </section>
    </div>
</div>
<script>
    $(function () {
        $('#btnRegister').click(function () {
            $(this).attr('disabled', true);
            $(this).html('<i class="fa fa-spin fa-spinner"></i> Đang gửi');
            $('#EmployerLoginForm').submit();
        })
    })
</script>
<?php
include('_footer.ctp');
?>
