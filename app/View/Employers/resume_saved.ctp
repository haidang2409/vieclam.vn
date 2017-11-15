<style>
    .select2-selection__placeholder
    {
        padding-left: 25px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="widget-box widget-color-blue3">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">
                        QUẢN LÝ THƯ MỤC
                    </h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-8">
                        <ul class="tree tree-unselectable tree-folder-select">
                            <li class="tree-branch">
                                <div class="tree-branch-header">
                                    <span class="tree-branch-name">
                                        <i class="icon-folder ace-icon fa fa-folder"></i>
                                        <span class="bolder tree-label">
                                            <a href="/nha-tuyen-dung/ho-so-da-luu">
                                                Tất cả
                                            </a>
                                        </span>
                                    </span>
                                </div>
                            </li>
                            <?php
                            $folders_options = null;
                            if(isset($folders) && count($folders) > 0)
                            {
                                foreach ($folders as $item)
                                {
                                    ?>
                                    <li class="tree-branch">
                                        <div class="tree-branch-header">
                                            <span class="tree-branch-name">
                                                <i class="icon-folder ace-icon fa fa-folder" style="<?php echo 'color: ' . $item['Folder']['color'];?>"></i>
                                                <span class="bolder tree-label">
                                                    <a href="/nha-tuyen-dung/ho-so-da-luu?folder=<?php echo $item['Folder']['id'];?>">
                                                        <?php
                                                        echo htmlentities($item['Folder']['folder_name'], ENT_QUOTES, 'UTF-8');
//                                                        $folders_options[$item['Folder']['id']] = htmlentities($item['Folder']['folder_name'], ENT_QUOTES, 'UTF-8');
                                                        $folders_options[$item['Folder']['id']] = $item['Folder']['folder_name'];
                                                        ?>
                                                    </a>
                                                </span>
                                                <span class="folder-action">
                                                    <i class="fa fa-pencil edit-folder" data-folder_name="<?php echo htmlentities($item['Folder']['folder_name'], ENT_QUOTES, 'UTF-8');?>" data-folder_id="<?php echo $item['Folder']['id'];?>" data-color="<?php echo $item['Folder']['color'];?>">

                                                    </i>
                                                    &nbsp;
                                                    <i class="fa fa-trash delete-folder" data-folder_id="<?php echo $item['Folder']['id'];?>">

                                                    </i>
                                                </span>
                                            </span>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <div class="text-center div-a-add-folder">
                            <a href="javascript:void (0)" id="add-folder" class="a-add-folder">Thêm thư mục</a>
                            <?php echo $this->Session->flash();?>
                        </div>
                        <div class="frm-add-folder">
                            <form class="form-horizontal" action="" method="post">
                                <div class="form-group">
                                    <label class="control-label col-sm-5">
                                        Tên thư mục
                                    </label>
                                    <div class="col-sm-7">
                                        <input id="folder_name" name="folder_name" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">
                                        Chọn màu
                                    </label>
                                    <div class="col-sm-7">
                                        <select id="color" name="color">
                                            <option value="#ac725e">#ac725e</option>
                                            <option value="#d06b64">#d06b64</option>
                                            <option value="#f83a22">#f83a22</option>
                                            <option value="#fa573c">#fa573c</option>
                                            <option value="#ff7537">#ff7537</option>
                                            <option value="#ffad46">#ffad46</option>
                                            <option value="#42d692">#42d692</option>
                                            <option value="#16a765">#16a765</option>
                                            <option value="#7bd148">#7bd148</option>
                                            <option value="#b3dc6c">#b3dc6c</option>
                                            <option value="#fbe983">#fbe983</option>
                                            <option value="#fad165">#fad165</option>
                                            <option value="#92e1c0">#92e1c0</option>
                                            <option value="#9fe1e7">#9fe1e7</option>
                                            <option value="#9fc6e7">#9fc6e7</option>
                                            <option value="#4986e7">#4986e7</option>
                                            <option value="#9a9cff">#9a9cff</option>
                                            <option value="#b99aff">#b99aff</option>
                                            <option value="#c2c2c2">#c2c2c2</option>
                                            <option value="#cabdbf">#cabdbf</option>
                                            <option value="#cca6ac">#cca6ac</option>
                                            <option value="#f691b2">#f691b2</option>
                                            <option value="#cd74e6">#cd74e6</option>
                                            <option value="#a47ae2">#a47ae2</option>
                                            <option value="#555">#555</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 text-center">
                                        <button id="btnCancel" type="reset" class="btn btn-xs btn-default">
                                            <i class="fa fa-ban"></i> Hủy
                                        </button>
                                        <button id="btnSaveAddFolder" type="button" class="btn btn-xs btn-primary">
                                            <i class="fa fa-save"></i> Lưu
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="frm-edit-folder ">
                            <form class="form-horizontal" action="" method="post">
                                <div class="form-group">
                                    <label class="control-label col-sm-5">
                                        Tên thư mục
                                    </label>
                                    <div class="col-sm-7">
                                        <input id="e_folder_name" name="folder_name" class="form-control" type="text">
                                        <input id="e_id" name="id" class="form-control" type="hidden">
                                        <span class="error-label" id="error-e_folder_name"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">
                                        Chọn màu
                                    </label>
                                    <div class="col-sm-7">
                                        <select id="e_color" name="color">
                                            <option value="#ac725e">#ac725e</option>
                                            <option value="#d06b64">#d06b64</option>
                                            <option value="#f83a22">#f83a22</option>
                                            <option value="#fa573c">#fa573c</option>
                                            <option value="#ff7537">#ff7537</option>
                                            <option value="#ffad46">#ffad46</option>
                                            <option value="#42d692">#42d692</option>
                                            <option value="#16a765">#16a765</option>
                                            <option value="#7bd148">#7bd148</option>
                                            <option value="#b3dc6c">#b3dc6c</option>
                                            <option value="#fbe983">#fbe983</option>
                                            <option value="#fad165">#fad165</option>
                                            <option value="#92e1c0">#92e1c0</option>
                                            <option value="#9fe1e7">#9fe1e7</option>
                                            <option value="#9fc6e7">#9fc6e7</option>
                                            <option value="#4986e7">#4986e7</option>
                                            <option value="#9a9cff">#9a9cff</option>
                                            <option value="#b99aff">#b99aff</option>
                                            <option value="#c2c2c2">#c2c2c2</option>
                                            <option value="#cabdbf">#cabdbf</option>
                                            <option value="#cca6ac">#cca6ac</option>
                                            <option value="#f691b2">#f691b2</option>
                                            <option value="#cd74e6">#cd74e6</option>
                                            <option value="#a47ae2">#a47ae2</option>
                                            <option value="#555">#555</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 text-center">
                                        <button id="btnCancelEdit" type="reset" class="btn btn-xs btn-default">
                                            <i class="fa fa-ban"></i> Hủy
                                        </button>
                                        <button id="btnSaveEditFolder" type="button" class="btn btn-xs btn-primary">
                                            <i class="fa fa-save"></i> Lưu
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="text-note">
                Lưu hồ sơ theo thư mục để dễ dàng quản lý, tìm kiếm, phân loại ứng viên
                <br>
                Các hồ sơ được lưu quá 12 tháng sẽ bị xóa khỏi hệ thống
            </div>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-6">
                    <form>
                        <div class="form-group has-feedback">
                            <?php
                            echo $this->Form->input('change_folder', array('name' => 'change_folder', 'id' => 'change_folder', 'type' => 'select', 'options' => $folders_options, 'empty' => '', 'label' => false, 'style' => 'width: 100% !important'));
                            ?>
                            <span class="fa fa-folder-open form-control-feedback folder-o blue" aria-hidden="true"></span>
                        </div>
                        <div class="text-note">
                            Chọn các ứng viên để di chuyển vào thư mục
                        </div>
                    </form>
                </div>
                <div class="col-sm-6 text-right bigger-120">
                    <?php echo number_format($this->Paginator->param('count'), 0, '', '.');?> hồ sơ đã lưu
                </div>
            </div>
            <div class="container-candidate">
                <table class="table">
                    <tr>
                        <td class="text-center">
                            <div class="checkbox">
                                <label>
                                    <input name="form-field-checkbox" id="chkAllResume" class="ace" type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </td>
                        <td class="bolder">Ứng viên</td>
                        <td class="bolder">Chức danh</td>
                        <td class="bolder text-center">Kinh nghiệm</td>
                        <td class="bolder text-center">Ngày lưu</td>
                        <td class="bolder text-center">Ngày cập nhật</td>
                        <td class="bolder">Thư mục</td>
                        <td class="bolder text-center">Thao tác</td>
                    </tr>
                    <?php
                    if(isset($resume_saved) && count($resume_saved) > 0)
                    {
                        foreach ($resume_saved as $item)
                        {
                            ?>
                            <tr>
                                <td class="text-center">
                                    <div class="checkbox">
                                        <label>
                                            <input name="form-field-checkbox" class="ace chkResume" type="checkbox" value="<?php echo $item['MemberEmployer']['id'];?>">
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a class="bolder" href="<?php echo $_base_url_employer?>/ho-so-da-luu/<?php echo $item['MemberEmployer']['id'];?>">
                                        <?php echo htmlentities($item['Member']['fullname'], ENT_QUOTES, 'UTF-8');?>
                                    </a>
                                </td>
                                <td>
                                    <?php
                                    echo htmlentities($item['Member']['title'], ENT_QUOTES, 'UTF-8');
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if($item['Member']['experience'])
                                    {
                                        echo $item['Member']['experience'] . ' năm';
                                    }
                                    ?>
                                </td>
                                <td class="center">
                                    <?php
                                    echo $this->Lib->convertDateTime_Mysql_to_Date($item['MemberEmployer']['date_saved']);
                                    ?>
                                </td>
                                <td class="text-center">
                                </td>
                                <td>
                                    <?php
                                    echo htmlentities($item['Folder']['folder_name'], ENT_QUOTES, 'UTF-8');
                                    ?>
                                </td>
                                <td class="text-center">
                                    <div class="">
                                        <div class="inline pos-rel">
                                            <a class="btn btn-xs btn-info" title="Xem hồ sơ" href="<?php echo $_base_url_employer?>/ho-so-ung-vien/<?php echo $item['MemberEmployer']['id'];?>">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button class="btn btn-xs btn-danger btn-delete-resume" data-resume_id="<?php echo $item['MemberEmployer']['id'];?>"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                <p style="font-size: 1.2em; font-style: italic">
                                    Không có hồ sơ
                                </p>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <div class="text-center">
                    <?php
                    if($this->params['paging']['MemberEmployer']['pageCount'] > 1)
                    {
                        ?>
                        <div class="pagination">
                            <?php echo $this->Paginator->numbers(array(
                                'separator' => '',
                                'currentTag' => 'a',
                                'currentClass' => 'active',
                                'ellipsis'=>'<a>...</a>',
                                'modulus' => 4,
                                'first' => 2,
                                'last' => 2
                            ));
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalDeleteResume" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Xác nhận xóa</h4>
            </div>
            <div class="modal-body">
                Xóa hồ sơ này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary btnDeleteResume">Xóa</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#change_folder').select2({
            placeholder: 'Chuyển vào thư mục',
            minimumResultsForSearch: -1
        });
        $('#color').ace_colorpicker();
        $('#e_color').ace_colorpicker();
        $('#chkAllResume').click(function () {
            if($(this).is(':checked') == true)
            {
                $('.chkResume').prop('checked', true);
            }
            else
            {
                $('.chkResume').prop('checked', false);
            }
        });
        $('#btnCancel').click(function () {
            $('.frm-add-folder').hide();
        });
        $('#add-folder').click(function () {
            $('.frm-edit-folder').hide();
            $('.frm-add-folder').fadeIn();
        });
        $('#btnSaveAddFolder').click(function () {
            var folder_name = $('#folder_name').val();
            var color = $('#color').val();
            if(folder_name != '' && color != '')
            {
                $.ajax({
                    url: '/folders/add_folder_ajax',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        folder_name: folder_name,
                        color: color
                    },
                    success: function (data) {
                        if(data.status == 'success')
                        {
                            alert_full('success', 'Đã thêm thư mục');
                        }
                        else if(data.status == 'fail')
                        {
                            alert_full('error', 'Lỗi thêm');
                        }
                        else
                        {
                            alert_full('warning', 'Vui lòng đăng nhập');
                        }
                        setTimeout(function () {
                            window.location = window.location;
                        }, 1500)
                    }
                })
            }
        });
        $('.delete-folder').on('click', function () {
            var folder_id = $(this).data('folder_id');
            if(folder_id != '')
            {
                $.ajax({
                    url: '/folders/delete_folder_ajax',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        folder_id: folder_id
                    },
                    success: function (data) {
                        if(data.status == 'success')
                        {
                            alert_full('success', 'Đã xóa thư mục');
                        }
                        else if(data.status == 'fail')
                        {
                            alert_full('error', 'Lỗi');
                        }
                        else if(data.status == 'exist_resume')
                        {
                            alert_full('warning', 'Không thể xóa do tồn tại hồ sơ');
                        }
                        else if(data.status == 'not_login')
                        {
                            alert_full('warning', 'Vui lòng đăng nhập');
                        }
                        setTimeout(function () {
                            window.location = window.location;
                        }, 1500)
                    }
                })
            }
        });
        //Edit
        $('#btnCancelEdit').click(function () {
            $('.frm-edit-folder').hide();
        });
        $('.edit-folder').on('click', function () {
            var id = $(this).data('folder_id');
            var folder_name = $(this).data('folder_name');
            var color = $(this).data('color');
            $('#e_id').val(id);
            $('#e_folder_name').val(folder_name);
            $('#e_color').ace_colorpicker('pick', color);
            $('.frm-add-folder').hide();
            $('.frm-edit-folder').fadeIn();
        });
        $('#btnSaveEditFolder').click(function () {
            var id = $('#e_id').val();
            var folder_name = $('#e_folder_name').val();
            var color = $('#e_color').val();
            if(folder_name == '')
            {
                $('#error-e_folder_name').html('Nhập tên thư mục');
                return false
            }
            else
            {
                $('#error-e_folder_name').hide();
            }
            $.ajax({
                url: '/folders/edit_folder_ajax',
                type: 'post',
                dataType: 'json',
                data: {
                    id: id,
                    folder_name: folder_name,
                    color: color
                },
                success: function (data) {
                    if(data.status == 'success')
                    {
                        alert_full('success', 'Đã cập nhật thư mục');
                    }
                    else if(data.status == 'fail')
                    {
                        alert_full('error', 'Lỗi');
                    }
                    else
                    {
                        alert_full('warning', 'Vui lòng đăng nhập');
                    }
                    setTimeout(function () {
                        window.location = window.location;
                    }, 1500)
                }
            })
        });
        $('#change_folder').change(function () {
            var folder_name = $(this).val();
            if(folder_name != '')
            {
                var selected_resume = $('.chkResume:checkbox:checked').map(function() {
                    return this.value;
                }).get();
                if(selected_resume.length == 0)
                {
                    alert_full('warning', 'Chọn hồ sơ để di chuyển');
                    $('#change_folder').val('').trigger('change');
                }
                else
                {
                    $.ajax({
                        url: '/members_employers/update_folder_ajax',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            folder_id: folder_name,
                            resume: selected_resume
                        },
                        success: function (data) {
                            if(data.status == 'success')
                            {
                                alert_full('success', 'Đã chuyển vào thư mục');
                            }
                            else if(data.status == 'fail')
                            {
                                alert_full('error', 'Lỗi');
                            }
                            else if(data.status == 'not_login')
                            {
                                alert_full('warning', 'Vui lòng đăng nhập');
                            }
                            setTimeout(function () {
                                window.location = window.location;
                            }, 1500)
                        }
                    })
                }
            }
        });
        $('.btn-delete-resume').on('click', function () {
            var resume_id = $(this).data('resume_id');
            $('.btnDeleteResume').data('resume_id', resume_id);
            $('#modalDeleteResume').modal('show');
        });
        $('.btnDeleteResume').click(function(){
            var resume_id = $(this).data('resume_id');
            if(resume_id != '')
            {
                $('#modalDeleteResume').modal('hide');
                $.ajax({
                    url: '/members_employers/delete_resume_ajax',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        resume_id: resume_id
                    },
                    success: function(data)
                    {
                        if(data.status == 'success')
                        {
                            alert_full('success', 'Đã xóa hồ sơ');
                        }
                        else if(data.status == 'fail')
                        {
                            alert_full('error', 'Lỗi');
                        }
                        else if(data.status == 'not_login')
                        {
                            alert_full('warning', 'Vui lòng đăng nhập');
                        }
                        setTimeout(function () {
                            window.location = window.location;
                        }, 1500)
                    }
                });
            }
        });
    })
</script>