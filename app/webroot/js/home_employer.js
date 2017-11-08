$(function () {
    $(document).on('click', '.btn-change-status', function () {
        var memberRecruitmentId = $(this).data('memberrecruitmentid');
        var recruitmentStatusId = $(this).data('recruitmentstatusid');
        var my_btn = $(this);
        if(memberRecruitmentId != '' && recruitmentStatusId != '')
        {
            $.ajax({
                url: '/members_recruitments/update_status',
                type: 'post',
                dataType: 'json',
                data: {
                    memberRecruitmentId: memberRecruitmentId,
                    recruitmentStatusId: recruitmentStatusId
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
                    setTimeout(function () {
                        window.location = window.location;
                    }, 1500)
                }
            })
        }
    });
});
function format_num(element) {
    var n = parseInt(element.value.replace(/\D/g,''),10);
    if(!isNaN(n))
    {
        element.value = n.toLocaleString();
    }
}