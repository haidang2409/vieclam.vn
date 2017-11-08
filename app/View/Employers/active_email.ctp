<?php
$title = 'Kích hoạt tài khoản';
include('_header.ctp');
?>
<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
            <?php echo $this->Form->create('Employer', array('method' => 'post', 'novalidate' => true));?>
            <h1>Kích hoạt tài khoản</h1>
            <div style="color: ">
                <?php
                echo $this->Session->flash();
                ?>
            </div>
            <div class="text-center-xs text-center">
                <a class="btn btn-index" href="<?php echo $_base_url_employer?>/dang-nhap" style="text-decoration: none">
                    <i class="fa fa-check"></i>
                    Đăng nhập
                </a>
            </div>
            <div class="clearfix"></div>

            <div class="separator">
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
            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading')
        })
    })
</script>
<?php include('_footer.ctp');?>
