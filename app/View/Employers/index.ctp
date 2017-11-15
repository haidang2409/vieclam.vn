<div class="container" style="min-height: 450px">
    <div class="row">
        <div class="col-md-9 col-sm-9">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <a href="/nha-tuyen-dung/viec-lam">
                        <div class="info-box">
                        <div class="icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <div class="content">
                            <div class="title">
                                Việc làm
                            </div>
                            <div class="">
                                <?php echo number_format($count_recruitment, 0, '', '.');?>
                                việc làm đã đăng tuyển
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="/nha-tuyen-dung/ho-so-du-tuyen">
                        <div class="info-box">
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="content">
                            <div class="title">
                                Ứng viên
                            </div>
                            <div class="">
                                <?php echo number_format($count_candidate, 0, '', '.');?> lượt ứng tuyển
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="/nha-tuyen-dung/ho-so-da-luu">
                        <div class="info-box">
                        <div class="icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <div class="content">
                            <div class="title">
                                Hồ sơ đã lưu
                            </div>
                            <div class="">
                                <?php echo number_format($count_resume_saved, 0, '', '.');?> hồ sơ đã lưu
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="/nha-tuyen-dung/tim-ung-vien">
                        <div class="info-box">
                        <div class="icon">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="content">
                            <div class="title">
                                Tìm hồ sơ
                            </div>
                            <div class="">
                                Trên <?php echo number_format($count_resume, 0, '', '.');?> hồ sơ ứng viên
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="/nha-tuyen-dung/dang-viec-lam">
                        <div class="info-box">
                        <div class="icon">
                            <i class="fa fa-plus"></i>
                        </div>
                        <div class="content">
                            <div class="title">
                                Đăng tin miễn phí
                            </div>
                            <div class="">
                                Đăng tin miễn phí không giới hạn
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="/nha-tuyen-dung/bao-gia-dich-vu">
                        <div class="info-box">
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <div class="content">
                            <div class="title">
                                Báo giá dịch vụ
                            </div>
                            <div class="">
                                Giá hợp lý trên từng gói tin
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <br><br>
                    <h3>THÔNG BÁO</h3>
                    <div class="info-alert">
                        Chương trình khuyến mãi 1 tặng 1 cho gói tin TOP LIST được gia hạn đến hết tháng 12 năm 2017.
                        <br>
                        Từ ngày 1/1/2018 chúng tôi áp dụng chính sách giá dịch vụ mới.
                        <a href="#">Xem chi tiết</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-3">
            <div class="employer-info">
                <div class="company-name text-center">
                    <h4>
                        <?php
                        echo $employers['Employer']['company_name'];
                        ?>
                        <small>
                            <?php echo $employers['Employer']['email'];?>
                        </small>
                    </h4>
                </div>
                <div class="image text-center">
                    <?php
                    $image = '/uploads/company/employer_default.jpg';
                    if($employers['Employer']['logo'] != '' && file_exists(WWW_ROOT . '/uploads/company/' . $employers['Employer']['logo']))
                    {
                        $image = '/uploads/company/' . $employers['Employer']['logo'];
                    }
                    ?>
                    <img src="<?php echo $image?>">
                </div>
            </div>
        </div>
    </div>
</div>