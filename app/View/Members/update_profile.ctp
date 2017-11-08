<div class="background-primary">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="search-item-clear"></div>
                <div class="background-white background-padding">
                    <div class="container_update_profile">
                        <div class="header-update">
                            <h4>
                                CẬP NHẬT TÀI KHOẢN
                            </h4>
                        </div>
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <?php
                                    echo $this->Session->flash();
                                    ?>
                                </div>
                            </div>
                            <?php
                            echo $this->Form->create('Member', array('id' => 'frmUpdate', 'method' => 'post', 'novalidate' => true, 'class' => 'form-horizontal'));
                            ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Họ tên <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-7">
                                    <?php
                                    echo $this->Form->input('fullname', array('id' => 'fullname', 'class' => '', 'label' => false, 'value' => $members['Member']['fullname']));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="col-sm-4 control-label">
                                    Giới tính <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        <label>
                                            <input name="Member[gender]" class="ace" type="radio" value="1" <?php if($members['Member']['gender'] == '1'){ echo 'checked';}?>>
                                            <span class="lbl"> Nam</span>
                                        </label>
                                        <label>
                                            <input name="Member[gender]" class="ace" type="radio" value="0" <?php if($members['Member']['gender'] == '0'){ echo 'checked';}?>>
                                            <span class="lbl"> Nữ</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Ngày sinh <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-7">
                                    <?php
                                    if($members['Member']['birthday'])
                                    {
                                        $birth = $members['Member']['birthday'] != '0000-00-00'? $this->Lib->convertDateTime_Mysql_to_Date($members['Member']['birthday']): '';
                                    }
                                    else
                                    {
                                        $birth = '';
                                    }
                                    echo $this->Form->input('birth', array('id' => 'birthday', 'type' => 'text', 'label' => false, 'class' => 'form-control', 'title' => 'Ngày sinh', 'value' => $birth));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Địa chỉ <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-7">
                                    <?php
                                    echo $this->Form->input('address', array('id' => 'address', 'class' => '', 'label' => false, 'value' => $members['Member']['address']));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Tỉnh thành <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-7">
                                    <?php
                                    echo $this->Form->input('province_id', array('id' => 'province_id', 'class' => '', 'label' => false, 'default' => $members['Member']['province_id'], 'options' => $provinces, 'empty' => ''));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Số điện thoại <font class="label-require">(*)</font>
                                </label>
                                <div class="col-sm-7">
                                    <?php
                                    echo $this->Form->input('phonenumber', array('id' => 'phonenumber', 'class' => '', 'label' => false, 'value' => $members['Member']['phonenumber']));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <a href="/doi-mat-khau">
                                        Đổi mật khẩu
                                    </a>

                                </div>
                                <div class="col-sm-3 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Lưu
                                    </button>
                                </div>
                            </div>
                            <?php
                            echo $this->Form->end();
                            ?>
                        </div>
                    </div>
                </div>
                <div class="search-item-clear"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $.datepicker.regional['cs'] = {
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            dayNames: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
            dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        };
        $.datepicker.setDefaults($.datepicker.regional['cs']);
        $('#birthday').datepicker({
            dateFormat: 'dd/mm/yy',
            defaultDate: '1/1/1991'
        });
        $('#province_id').select2({
            minimunResultsForSearch: -1,
            placeholder: 'Chọn tỉnh thành'
        })
    })
</script>