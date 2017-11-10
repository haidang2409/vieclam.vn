<div class="main-content" id="content-recruitment">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="menu-icon ace-icon fa fa-home home-icon"></i>
                    <a href="/admin">Trang chủ</a>
                </li>
                <li><a href="/admin/recruitments">Tuyển dụng</a> </li>
                <li>Sửa tin tuyển dụng</li>
            </ul><!-- /.breadcrumb -->
            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon">
                        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div><!-- /.nav-search -->
        </div>
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Sửa tin tuyển dụng
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1 col-xs-12">
                            <?php
                            echo $this->Session->flash();
                            ?>
                            <?php echo $this->Form->create('Recruitment', array('class' => 'form-horizontal form_has_addon', 'novalidate' => true));?>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">
                                    Chức danh <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->input('title', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Ví dụ: Tuyển nhân viên bán hàng', 'value' => $recruitments['Recruitment']['title']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">
                                    Cấp bậc <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->input('level_id', array('id' => 'level_id', 'type' => 'select', 'label' => false, 'class' => 'form-control', 'title' => 'Cấp bậc', 'options' => $levels, 'empty' => '', 'style' => 'width: 100% !important', 'default' => $recruitments['Recruitment']['level_id']));?>
                                    <label for="level_id" generated="true" class="error"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">
                                    Ngành nghề <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->input('recruitments_jobs', array('id' => 'recruitments_jobs', 'type' => 'select', 'label' => false, 'class' => 'form-control', 'title' => 'Cấp bậc', 'options' => $jobs, 'empty' => '', 'multiple' => true, 'style' => 'width: 100% !important', 'selected' => $recruitments_jobs_selected));?>
                                    <label for="recruitments_jobs" generated="false" class="error"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fullname" class="col-sm-3 control-label">
                                    Nơi làm việc <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-9 select-50">
                                    <?php echo $this->Form->input('recruitments_provinces', array('id' => 'recruitments_provinces', 'label' => false, 'class' => 'form-control', 'title' => 'Tỉnh thành', 'options' => $provinces, 'empty' => '', 'style' => 'width: 100% !important', 'multiple' => true, 'selected' => $recruitments_provinces_selected));?>
                                    <label for="recruitments_provinces" generated="true" class="error"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phonenumber" class="col-sm-3 col-xs-12 control-label">
                                    Mức lương <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-3 col-xs-6">
                                    <?php echo $this->Form->input('salary_min', array('id' => 'salary_min', 'label' => false, 'class' => 'form-control', 'title' => 'Mức lương tối thiểu', 'placeholder' => 'Mức lương tối thiểu (VND)', 'type' => 'text', 'value' => number_format($recruitments['Recruitment']['salary_min'], 0, '', ',')));?>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <?php echo $this->Form->input('salary_max', array('id' => 'salary_max', 'label' => false, 'class' => 'form-control', 'title' => 'Mức lương tối đa', 'placeholder' => 'Mức lương tối đa (VND)', 'type' => 'text', 'value' => number_format($recruitments['Recruitment']['salary_max'], 0, '', ',')));?>
                                </div>
                                <div class="col-sm-3 col-xs-12 text-center">
                                    <div style="padding-top: 5px">
                                        <label>
                                            <input name="data[Recruitment][hide_salary]" class="ace ace-switch ace-switch-6" type="checkbox" value="1" <?php if($recruitments['Recruitment']['hide_salary'] == 1) { echo 'checked';}?>>
                                            <span class="lbl"> &nbsp;&nbsp; Ẩn mức lương</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">
                                    Mô tả công việc <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->input('description', array('type' => 'textarea', 'label' => false, 'class' => 'form-control', 'title' => 'Mô tả công việc', 'placeholder' => 'Nhập mô tả công việc', 'value' => $recruitments['Recruitment']['description']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">
                                    Yêu cầu công việc <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->input('require', array('type' => 'textarea', 'label' => false, 'class' => 'form-control', 'title' => 'Yêu cầu công việc', 'placeholder' => 'Nhập yêu cầu công việc', 'value' => $recruitments['Recruitment']['require']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phonenumber" class="col-sm-3 control-label">
                                    Ngôn ngữ trình bày hồ sơ
                                </label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->input('recruitment_language_id', array('id' => 'language_recruitment_id', 'type' => 'select', 'label' => false, 'class' => 'form-control', 'title' => 'Ngôn ngữ trình bày hồ sơ', 'options' => $recruitments_languages, 'default' => $recruitments['Recruitment']['recruitment_language_id']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">
                                    Người liên hệ
                                </label>
                                <div class="col-sm-3">
                                    <?php echo $this->Form->input('fullname', array('label' => false, 'class' => 'form-control', 'value' => $recruitments['Recruitment']['fullname']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">
                                    Địa chỉ email nhận hồ sơ
                                </label>
                                <div class="col-sm-3">
                                    <?php echo $this->Form->input('email', array('type' => 'text', 'label' => false, 'class' => 'form-control', 'value' => $recruitments['Recruitment']['email']));?>
                                </div>
                            </div>
                            <hr class="dotted">
                            <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">
                                    Tên công ty <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->input('company_name', array('name' => 'data[Employer][company_name]', 'type' => 'text', 'label' => false, 'class' => 'form-control', 'title' => 'Tên công ty', 'value' => $employers['Employer']['company_name']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">
                                    Địa chỉ công ty <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->input('address', array('name' => 'data[Employer][address]', 'type' => 'text', 'label' => false, 'class' => 'form-control', 'title' => 'Địa chỉ công ty', 'value' => $employers['Employer']['address'], 'placeholder' => 'Ví dụ: Số 86 Mạc Thiên Tích, Xuân Khánh, Ninh Kiều'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">
                                    Thông tin công ty <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->input('description_company', array('name' => 'data[Employer][description]', 'type' => 'textarea', 'label' => false, 'class' => 'form-control', 'title' => 'Thông tin công ty', 'value' => $employers['Employer']['description']));?>
                                </div>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-index" type="submit">
                                    <i class="fa fa-save"></i>
                                    Lưu
                                </button>
                            </div>
                            <?php
                            echo $this->Form->end();?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<script>
    $(function () {
        //
        $('input').attr('autocomplete','off');
        $('#level_id').select2({
            minimumResultsForSearch: -1,
            placeholder: 'Chọn cấp bậc'
        });
        $('#recruitments_jobs').select2({
            minimumResultsForSearch: -1,
            placeholder: 'Chọn ngành nghề',
            maximumSelectionLength: 3
        });
        $('#recruitments_provinces').select2(
            {
                placeholder: "Chọn nơi làm việc",
                maximumSelectionLength: 3
            }
        );
        $('#language_recruitment_id').select2({
            minimumResultsForSearch: -1
        });

        //

        $('#scale').select2({
            placeholder: "Chọn quy mô công ty"
        });
        $('#RecruitmentAddForm').validate({
            rules: {
                'data[Recruitment][title]': {
                    required: true,
                    maxlength: 70
                },
                'data[Recruitment][level_id]': {
                    required: true
                },
                'data[Recruitment][recruitments_jobs][]': {
                    required: true,
                    maxlength: 3
                },
                'data[Recruitment][recruitments_provinces][]': {
                    required: true,
                    maxlength: 3
                },
                'data[Recruitment][salary_min]': {
                    required: true,
                    accept: '([0-9]|[,])+'
                },
                'data[Recruitment][salary_max]': {
                    required: true,
                    accept: '([0-9]|[,])+'
                },
                'data[Employer][company_name]': {
                    required: true
                },
                'data[Employer][address]': {
                    required: true
                },
                'data[Employer][description]': {
                    required: true
                }

            },
            messages: {
                'data[Recruitment][title]': {
                    required: 'Vui lòng nhập chức danh, công việc',
                    maxlength: 'Vui lòng nhập không quá 70 ký tự'
                },
                'data[Recruitment][level_id]': {
                    required: 'Vui lòng chọn cấp bậc'
                },
                'data[Recruitment][recruitments_jobs][]': {
                    required: 'Vui lòng chọn ngành nghề',
                    maxlength: 'Vui lòng không chọn quá 3 ngành nghề'
                },
                'data[Recruitment][recruitments_provinces][]': {
                    required: 'Vui lòng chọn nơi làm việc',
                    maxlength: 'Vui lòng chọn không quá 3 nơi làm việc'
                },
                'data[Recruitment][salary_min]': {
                    required: 'Vui lòng nhập mức lương tối thiểu',
                    accept: 'Hãy nhập đúng mức lương tối thiểu'
                },
                'data[Recruitment][salary_max]': {
                    required: 'Vui lòng nhập mức lương tối đa',
                    accept: 'Hãy nhập đúng mức lương tối đa'
                },
                'data[Employer][company_name]': {
                    required: 'Nhập tên công ty'
                },
                'data[Employer][address]': {
                    required: 'Nhập địa chỉ công ty'
                },
                'data[Employer][description]': {
                    required: 'Giới thiệu về công ty'
                }
            }
        });
        $('#salary_min').keyup(function () {
            format_num(this);
        });
        $('#salary_max').keyup(function () {
            format_num(this);
        });
    })
</script>