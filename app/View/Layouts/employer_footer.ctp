<div class="alert-full">
    <a class="close" id="closeAlertFull"><i class="fa fa-remove"></i> </a>
    <div class="content">

    </div>
</div>
<div class="footer text-center-xs">
    <div class="container" style="padding-top: 10px; padding-bottom: 10px;">
        <div class="row">
            <div class="col-sm-12" style="font-size: 14px">
                CÔNG TY TNHH TƯ VẤN VÀ ĐÀO TẠO HIỆN THỰC ƯỚC MƠ
                <br>
                <i class="fa fa-phone"></i> 0901 032 320 - <i class="fa fa-envelope"></i> cskh@dream.edu.vn
                <br>
                <i class="fa fa-home"></i>
                Địa chỉ VP: Số 86 Mạc Thiên Tích, Phường Xuân Khánh, Quận Ninh Kiều, TP Cần Thơ
                <br>
            </div>
        </div>
    </div>
</div>
<?php
$path_file = WWW_ROOT . DS . 'counter.txt';
$num = (int)file_get_contents($path_file) + 1;
file_put_contents(WWW_ROOT . DS . 'counter.txt', $num);
?>
<?php
//echo $this->element('sql_dump');
//?>
<!--<script>-->
<!--    $(function () {-->
<!--        $('.cake-sql-log').addClass('table');-->
<!--    });-->
<!--</script>-->