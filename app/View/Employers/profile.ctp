<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2>Cập nhật thông tin</h2>
            <hr class="hr-double">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-xs-12">
                    <?php
                    echo $this->Session->flash();
                    ?>
                    <?php echo $this->Form->create('Employer', array('class' => 'form-horizontal form_has_addon', 'novalidate' => true));?>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Tên công ty (*)
                        </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('company_name', array('label' => false, 'class' => 'form-control', 'title' => 'Tên công ty', 'value' => $employers['Employer']['company_name']));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Địa chỉ
                        </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('address', array('label' => false, 'class' => 'form-control', 'title' => 'Địa chỉ', 'value' => $employers['Employer']['address']));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fullname" class="col-sm-3 control-label">
                            Tỉnh thành
                        </label>
                        <div class="col-sm-9 select-50">
                            <?php echo $this->Form->input('province_id', array('id' => 'province', 'label' => false, 'class' => 'form-control', 'title' => 'Tỉnh thành', 'default' => $employers['Province']['id'], 'options' => $provinces, 'empty' => '', 'style' => 'width: 100% !important'));?>
                            <label for="province" generated="true" class="error"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phonenumber" class="col-sm-3 control-label">
                            Quy mô công ty
                        </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('scale_id', array('id' => 'scale', 'label' => false, 'class' => 'form-control', 'title' => 'Quy mô công ty', 'default' => $employers['Scale']['id'], 'options' => $scales, 'empty' => '', 'style' => 'width: 100% !important'));?>
                            <label for="scale" generated="true" class="error"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phonenumber" class="col-sm-3 control-label">
                            Ngành nghề (*)
                        </label>
                        <div class="col-sm-9 select-50">
                            <?php
                            $selected_jobs = null;
                            if(count($employers_jobs) > 0)
                            {
                                $i = 0;
                                foreach ($employers_jobs as $item)
                                {
                                    $selected_jobs[$i] = $item['EmployerJob']['job_id'];
                                    $i = $i + 1;
                                }
                            }
                            echo $this->Form->input('employers_jobs', array('id' => 'employers_jobs', 'label' => false, 'class' => 'form-control', 'title' => 'Ngành nghề', 'options' => $jobs, 'multiple' => true, 'empty' => '', 'style' => 'width: 100% !important', 'selected' => $selected_jobs));
                            ?>
                            <div class="div-hint">
                                Chọn tối đa 3 ngành nghề
                            </div>
                        </div>
                    </div>
                    <hr class="dotted">
                    <div class="form-group">
                        <label for="phonenumber" class="col-sm-3 control-label">
                            Người liên hệ
                        </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('fullname', array('id' => 'fullname', 'label' => false, 'class' => 'form-control', 'title' => 'Người liên hệ', 'value' => $employers['Employer']['fullname']));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phonenumber" class="col-sm-3 control-label">
                            Số điện thoại
                        </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('phone', array('id' => 'district', 'type' => 'text', 'label' => false, 'class' => 'form-control', 'title' => 'Số điện thoại', 'value' => $employers['Employer']['phone']));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">
                            Giới thiệu về công ty
                        </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('description', array('type' => 'textarea', 'label' => false, 'class' => 'form-control', 'title' => 'Giới thiệu công ty', 'value' => $employers['Employer']['description']));?>
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
</div>
<script>
    $(function () {
        $('#province').select2(
            {
                placeholder: "Chọn tỉnh thành"
            }
        );
        $('#scale').select2({
            placeholder: "Chọn quy mô công ty"
        });
        $('#employers_jobs').select2({
            placeholder: "Chọn ít nhất một ngành nghề",
            maximumSelectionLength: 3,
            minimumSelectionLength: 1
        });
        $('#EmployerProfileForm').validate({
            rules: {
                'data[Employer][company_name]': {
                    required: true,
                    minlength: 5,
                    maxlength: 200
                },
                'data[Employer][address]': {
                    required: true,
//                    minlength: 5,
                    maxlength: 200
                },
                'data[Employer][province_id]': {
                    required: true
                },
                'data[Employer][employers_jobs]': {
                    required: true
                },
                'data[Employer][scale_id]': {
                    required: true
                }
            },
            messages: {
                'data[Employer][company_name]': {
                    required: 'Nhập tên công ty',
                    minlength: 'Tên công ty lớn hơn 5 ký tự',
                    maxlength: 'Tên công ty nhở hơn 200 ký tự'
                },
                'data[Employer][address]': {
                    required: 'Nhập địa chỉ công ty',
//                    minlength: 'Địa chỉ phải từ',
                    maxlength: '200'
                },
                'data[Employer][province_id]': {
                    required: 'Chọn  tỉnh thành'
                },
                'data[Employer][employers_jobs]': {
                    required: 'Chọn ít nhất một ngành nghề'
                },
                'data[Employer][scale_id]': {
                    required: 'Chọn quy mô công ty'
                }
            }
        });
    })
</script>