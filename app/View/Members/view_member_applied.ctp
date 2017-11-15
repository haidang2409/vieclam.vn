<?php
$html_status = '<ul class="dropdown-menu dropdown-all dropdown-status dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">';
if(isset($status) && count($status) > 0)
{
    foreach ($status as $item)
    {
        if($item['RecruitmentStatus']['id'] == $members_recruitments['MemberRecruitment']['recruitment_status_id'])
        {
            $style = 'style="font-weight: bolder;"';
            $icon = 'fa-circle';
        }
        else
        {
            $style = '';
            $icon = 'fa-circle-thin';
        }
        $html_status = $html_status .
            '<li>
            <a ' . $style . ' href="javascript:void(0)" class="tooltip-info change-status" data-rel="tooltip" title="" data-original-title="View" data-status_id="' . $item['RecruitmentStatus']['id'] . '" data-member_recruitment="' . $members_recruitments['MemberRecruitment']['id'] . '">
                <i class="fa ' . $icon . ' ' . $item['RecruitmentStatus']['color'] . ' "></i> ' . $item['RecruitmentStatus']['status_name'] .
            '</a>
            </li>';

    }
}
$html_status = $html_status . '</ul>';
$label = 'Hồ sơ ứng viên dự tuyển';
$members = $members_recruitments;
include ('resume.ctp');
?>
<script>
    $(function () {
        $('.change-status').on('click', function(){
            var status_id = $(this).data('status_id');
            var member_recruitment = $(this).data('member_recruitment');
            if(status_id != '' && member_recruitment != '')
            {
                $.ajax({
                    url: '/members_recruitments/update_status',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        recruitmentStatusId: status_id,
                        memberRecruitmentId: member_recruitment
                    },
                    success: function (data) {
                        if(data.status == 'success')
                        {
                            alert_full('success', 'Đã cập nhật trạng thái hồ sơ');
                        }
                        else if(data.status == 'fail')
                        {
                            alert_full('error', 'Lỗi, vui lòng thử lại sau');
                        }
                        else if(data.status == 'not_login')
                        {
                            alert_full('warning', 'Vui lòng <a href="/nha-tuyen-dung/dang-nhap"> đăng nhập </a>.');
                        }
                        window.location = window.location;
                    }
                })
            }
        });
        $('.btn-save-resume').click(function () {
            var member_id = $(this).data('member_id');
            if(member_id != '')
            {
                $.ajax({
                    url: '/members_employers/save_resume_ajax',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        member_id: member_id,
                        action: 'save_resume'
                    },
                    success: function (data) {
                        if(data.status == 'success')
                        {
                            alert_full('success', 'Đã lưu hồ sơ');
                            $('.btn-save-resume').html('<i class="fa fa-save"> </i> Đã lưu');
                            $('.btn-save-resume').removeClass('btn-yellow');
                            $('.btn-save-resume').addClass('btn-success');
                            $('.btn-save-resume').data('member_id', '');
                        }
                        else if(data.status == 'fail')
                        {
                            alert_full('error', 'Lỗi, vui lòng thử lại sau');
                        }
                        else if(data.status == 'not_login')
                        {
                            alert_full('warning', 'Vui lòng <a href="/nha-tuyen-dung/dang-nhap"> đăng nhập </a>.');
                        }
                    },
                });
            }
        })
    })
</script>
