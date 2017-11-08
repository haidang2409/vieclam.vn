<?php
$url_search = $_base_url_employer . '/ho-so-ung-vien?';
if($recruitmentId != '')
{
    $url_search = $url_search . 'recruitmentId=' . $recruitmentId;
}
$html_status = '<ul class="dropdown-menu dropdown-all dropdown-status dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">';
$html_status = $html_status .
    '<li>
        <a href="' . $url_search  . '" class="tooltip-info" data-rel="tooltip" title="Đã xem hồ sơ" data-original-title="Đã xem hồ sơ">
            <i class="fa fa-circle-thin d"></i> Tất cả
        </a>
    </li>
    <li>
        <a href="' . $url_search . '&isViewed=1" class="tooltip-info" data-rel="tooltip" title="Đã xem hồ sơ" data-original-title="Đã xem hồ sơ">
            <i class="fa fa-circle-thin d"></i> Đã xem
        </a>
    </li>
    <li>
        <a href="' . $url_search . '&isViewed=0" class="tooltip-info" data-rel="tooltip" title="Chưa xem hồ sơ" data-original-title="Chưa xem hồ sơ">
            <i class="fa fa-circle-thin d"></i> Chưa xem
        </a>
    </li>';
if(isset($status) && count($status) > 0)
{
    foreach ($status as $item)
    {
        $html_status = $html_status .
            '<li>
            <a href="' . $url_search . '&recruitmentStatus=' . $item['RecruitmentStatus']['id'] . '" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                <i class="fa fa-circle-thin ' . $item['RecruitmentStatus']['color'] . ' "></i> ' . $item['RecruitmentStatus']['status_name'] .
            '</a>
            </li>';
    }
}
$html_status = $html_status . '</ul>';
?>
<div class="container">
    <div class="row">
        <div class="col-sm-5">
            <h4>DANH SÁCH ỨNG VIÊN DỰ TUYỂN</h4>
        </div>
        <div class="col-sm-7">
            <form class="form-horizontal" method="get" id="frmFilterRecruitment">
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <i class="fa fa-filter"></i>
                        Lọc theo việc làm
                    </label>
                    <div class="col-sm-9">
                        <?php
                        echo $this->Form->input('recruitment_id', array('type' => 'select', 'class' => 'form-control', 'label' => false, 'empty' => 'Tất cả việc làm', 'options' => $recruitments_option, 'style' => 'width: 100% !important', 'id' => 'sltRecruitmentId', 'name' => 'recruitmentId', 'default' => $recruitmentId))
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <button class="btn btn-info"><i class="fa fa-print"></i> In danh sách</button>
            <button class="btn btn-success"><i class="fa fa-file-excel-o"></i> Xuất danh sách</button>
        </div>
        <div class="col-sm-6 text-right bigger-110" style="padding-top: 7px">
            <span>
                <?php echo number_format($this->Paginator->param('count'), 0, '', '.');?> ứng viên
            </span>&nbsp;&nbsp;
            <a href="" class="dropdown-toggle" data-toggle="dropdown" data-position="auto">
                <i class="ace-icon fa fa-filter icon-only bigger-110"></i> Lọc theo trạng thái
            </a>
            <?php
            echo $html_status;
            ?>
        </div>
        <div class="col-sm-12">
            <div class="container-candidate">
                <table class="table">
                    <tr>
                        <td class="text-center">
                            <div class="checkbox">
                                <label>
                                    <input name="form-field-checkbox" class="ace" type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </td>
                        <td class="bolder">Ứng viên</td>
                        <td class="bolder text-center">Kinh nghiệm</td>
                        <td class="bolder text-center">Ngày ứng tuyển</td>
                        <td class="bolder">Trạng thái</td>
                        <td class="bolder text-center">Đã lưu</td>
                        <td class="bolder text-center">Thao tác</td>
                    </tr>
                    <?php
                    if(isset($candidates) && count($candidates) > 0)
                    {
                        foreach ($candidates as $item)
                        {
                            ?>
                            <tr class="<?php if($item['MemberRecruitment']['is_viewed'] == 0) { echo 'un-read';}?>">
                                <td class="text-center">
                                    <div class="checkbox">
                                        <label>
                                            <input name="form-field-checkbox" class="ace" type="checkbox">
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a class="bolder" href="<?php echo $_base_url_employer?>/ho-so-ung-vien/<?php echo $item['MemberRecruitment']['id'];?>">
                                        <?php echo htmlentities($item['Member']['fullname'], ENT_QUOTES, 'UTF-8');?>
                                    </a>
                                    <?php
                                    echo ' - ' . htmlentities($item['Member']['title'], ENT_QUOTES, 'UTF-8');
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
                                    echo $this->Lib->convertDateTime_Mysql_to_Date($item['MemberRecruitment']['date_applied']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($item['MemberRecruitment']['recruitment_status_id'])
                                    {
                                        ?>
                                        <span class="span-status">
                                            <i class="fa fa-circle-thin <?php echo $item['RecruitmentStatus']['color'];?>"></i>
                                                <?php echo $item['RecruitmentStatus']['status_name'];?>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if(!is_null($arr_resume_saved) && in_array($item['Member']['id'], $arr_resume_saved))
                                    {
                                        echo '<i class="fa fa-check text-success"></i>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <div class="">
                                        <div class="inline pos-rel">
                                            <a class="btn btn-xs btn-info" title="Xem hồ sơ" href="<?php echo $_base_url_employer?>/ho-so-ung-vien/<?php echo $item['MemberRecruitment']['id'];?>">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                            <button title="Thay đổi trạng thái" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-status dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                <?php
                                                if(isset($status) && count($status) > 0)
                                                {
                                                    foreach ($status as $st)
                                                    {
                                                    ?>
                                                        <li>
                                                            <a href="javascript: void(0)" data-memberRecruitmentId="<?php echo $item['MemberRecruitment']['id'];?>" data-recruitmentStatusId="<?php echo $st['RecruitmentStatus']['id'];?>" class="btn-change-status tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                                <i class="fa fa-circle-thin <?php echo $st['RecruitmentStatus']['color'];?>"></i>
                                                                <?php echo $st['RecruitmentStatus']['status_name'];?>
                                                             </a>
                                                        </li>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
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
                            <td colspan="7" class="text-center">
                                <p style="font-size: 1.2em; font-style: italic">
                                    Không có ứng viên
                                </p>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <div class="text-center">
                    <?php
                    if($this->params['paging']['Recruitment']['pageCount'] > 1)
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
<script>
    $(function () {
        $('#sltRecruitmentId').select2({
//            'placeholder': 'Tìm theo việc làm'
        });
        $('#sltRecruitmentId').change(function () {
            $('#frmFilterRecruitment').submit();
        });

    })
</script>