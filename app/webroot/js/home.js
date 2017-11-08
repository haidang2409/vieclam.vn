function search_index() {
    var key_word = $('#key_word').val() != '' ? '?key_word=' + $('#key_word').val(): '';
    var job_link = $('#category_search').val() != ''? '/' + $('#category_search').val(): '';
    var provicne_link = $('#province_search').val() != ''? '/' + $('#province_search').val(): '';
    window.location = '/tim-viec-lam' + job_link + provicne_link + key_word
}
$.ajax({
    url: '/members/get_employer_view_ajax',
    type: 'get',
    dataType: 'json',
    success: function (data) {
        if(data.length > 0)
        {
            var html = '';
            var limit = 5;
            var length = data.length;
            if(length < 5)
            {
                limit = length;
            }
            $('.sum-bell').html(length);
            for(var i = 0; i < limit; i++)
            {
                var text = '<span class="name bolder">' + data[i]['company_name'] + '</span> đã xem ';
                if(data[i]['is_saved'] == true)
                {
                    text = text + ' và lưu '
                }
                text = text + ' hồ sơ của bạn';
                html  = html + '<li class="li-alert-item"><a href="#">' + text + '</a></li>';
            }
            html = html + '<li class="divider visible-xs"></li>' +
                '<li class="li-alert-all"><a href="/nha-tuyen-dung-xem-ho-so" class="text-center">Xem tất cả</a></li>';
            $('.dropdown-bell').html(html);
        }
        else
        {
            $('.dropdown-bell').html('<li class="not-alert-item"><a href="javascript: void(0)">Không có thông báo mới</a> </li>');
        }
    }
});
$('.btn-save-recruitment').on('click', function(){
    var recruitmentId = $(this).data('recruitment_id');
    var abc = $(this);
    if(recruitmentId != '')
    {
        $.ajax({
            url: '/recruitments/save',
            type: 'post',
            dataType: 'json',
            data: {
                recruitmentId: recruitmentId
            },
            success: function(data){
                if(data.status == 'success')
                {
                    abc.addClass('recruitment-saved');
                    abc.html('<i class="fa fa-heart saved"></i>');
                    alert_full('success', 'Đã lưu');
                }
                else if(data.status == 'not_login')
                {
                    alert_full('warning', 'Vui lòng <a href="/dang-nhap">đăng nhập</a> trước khi lưu');
                }
                else if(data.status == 'deleted')
                {
                    abc.removeClass('recruitment-saved');
                    abc.html('<i class="fa fa-heart-o"></i>');
                    alert_full('success', 'Đã xóa khỏi tin đã lưu');
                }
                else if(data.status == 'applied')
                {
                    alert_full('warning', 'Tin đã ứng tuyển');
                }
                else if(data.status == 'fail')
                {
                    alert_full('error', 'Lỗi. Vui lòng thử lại sau');
                }
            }
        })
    }
});
$('.btn-save-recruitment-detail').on('click', function(){
    var recruitmentId = $(this).data('recruitment_id');
    var abc = $(this);
    if(recruitmentId != '')
    {
        $.ajax({
            url: '/recruitments/save',
            type: 'post',
            dataType: 'json',
            data: {
                recruitmentId: recruitmentId
            },
            success: function(data){
                if(data.status == 'success')
                {
                    $('.btn-save-recruitment-detail').removeClass('btn-warning');
                    $('.btn-save-recruitment-detail').addClass('btn-success');
                    $('.btn-save-recruitment-detail').html('<i class="fa fa-heart saved"></i> Đã lưu');
                    alert_full('success', 'Đã lưu');
                }
                else if(data.status == 'not_login')
                {
                    alert_full('warning', 'Vui lòng <a href="/dang-nhap">đăng nhập</a> trước khi lưu');
                }
                else if(data.status == 'deleted')
                {
                    abc.removeClass('btn-success');
                    abc.addClass('btn-warning');
                    abc.html('<i class="fa fa-heart-o"></i> Lưu');
                    alert_full('success', 'Đã xóa khỏi tin đã lưu');
                }
                else if(data.status == 'applied')
                {
                    alert_full('warning', 'Tin đã ứng tuyển');
                }
                else if(data.status == 'fail')
                {
                    alert_full('error', 'Lỗi. Vui lòng thử lại sau');
                }
            }
        })
    }
});
$('.btn-apply-recruitment').click(function(){
    var recruitmentId = $(this).data('recruitment_id');
    var abc = $(this);
    if(recruitmentId != '')
    {
        $.ajax({
            url: '/recruitments/apply_recruitment',
            type: 'post',
            dataType: 'json',
            data: {
                recruitmentId: recruitmentId
            },
            success: function(data){
                if(data.status == 'success')
                {
                    $('.btn-save-recruitment-detail').removeClass('btn-warning');
                    $('.btn-save-recruitment-detail').addClass('btn-success');
                    $('.btn-save-recruitment-detail').html('<i class="fa fa-heart saved"></i> Đã lưu');
                    $('.btn-apply-recruitment').removeClass('btn-warning');
                    $('.btn-apply-recruitment').addClass('btn-success');
                    $('.btn-apply-recruitment').html('<i class="fa fa-heart saved"></i> Đã nộp đơn');
                    alert_full('success', 'Đã ứng tuyển');
                }
                else if(data.status == 'not_login')
                {
                    alert_full('warning', 'Vui lòng <a href="/dang-nhap">đăng nhập</a> để ứng tuyển');
                }
                else if(data.status == 'applied')
                {
                    alert_full('warning', 'Bạn đã ứng tuyển tin này');
                }
                else if(data.status == 'fail')
                {
                    alert_full('error', 'Lỗi. Vui lòng thử lại sau');
                }
            }
        })
    }
});
//Update resume
$('#btnSaveGeneral').click(function () {
    if($.trim($('#fullname').val()) == '')
    {
        $('#fullname').addClass('error-input');
        $('.error-fullname').fadeIn();
        return false;
    }
    else
    {
        $('#fullname').removeClass('error-input');
        $('.error-fullname').hide();
    }
    if($.trim($('#title').val()) == '')
    {
        $('#title').addClass('error-input');
        $('.error-title').fadeIn();
        return false;
    }
    else
    {
        $('#title').removeClass('error-input');
        $('.error-title').hide();
    }
    if($.trim($('#experience').val()) == '')
    {
        $('#experience').addClass('error-input');
        $('.error-experience').fadeIn();
        return false;
    }
    else
    {
        $('#experience').removeClass('error-input');
        $('.error-experience').hide();
    }
    if($.trim($('#level').val()) == '')
    {
        $('.error-level').fadeIn();
        return false
    }
    else
    {
        $('.error-level').hide();
    }
    //
    $('#modalGeneral').modal('hide');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            'action': 'update_general',
            'fullname': $('#fullname').val(),
            'title': $('#title').val(),
            'experience': $('#experience').val(),
            'level': $('#level').val()
        },
        success: function(data){
            finish_alert_update(data);
        }
    })
});
$('#btnSaveSummary').click(function(){
    if($.trim($('#summary').val()) == '')
    {
        $('#summary').addClass('error-input');
        $('.error-summary').fadeIn();
    }
    else
    {
        $('#modalSummary').modal('hide');
        $.ajax({
            url: '/members/update_resume_ajax',
            type: 'post',
            dataType: 'json',
            data: {
                'action': 'update_summary',
                'summary': $('#summary').val()
            },
            success: function (data) {
                finish_alert_update(data);
            }
        })
    }
});
$('#btnAddLanguage').click(function(){
    if($.trim($('#language').val()) == '')
    {
        $('.error-language').fadeIn();
        return false;
    }
    else
    {
        $('.error-language').hide();
    }
    if($.trim($('#language_level').val()) == '')
    {
        $('.error-language_level').fadeIn();
        return false;
    }
    else
    {
        $('.error-language_level').hide();
    }
    //
    $('#modalAddLanguage').modal('hide');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'add_language',
            language: $('#language').val(),
            language_level: $('#language_level').val()
        },
        success: function (data) {
            finish_alert_update(data);
        }
    })
});
$('.edit-language').click(function(){
    var language = $(this).data('language');
    var language_level = $(this).data('language_level');
    var id = $(this).data('id');
    $('#e_language').val(language).trigger('change');
    $('#e_language_level').val(language_level).trigger('change');
    $('#ml_id').val(id);
    $('#modalEditLanguage').modal('show');
});
$('#btnEditLanguage').click(function(){
    if($.trim($('#e_language').val()) == '')
    {
        $('.error-e_language').fadeIn();
        return false;
    }
    else
    {
        $('.error-language').hide();
    }
    if($.trim($('#e_language_level').val()) == '')
    {
        $('.error-e_language_level').fadeIn();
        return false;
    }
    else
    {
        $('.error-language_level').hide();
    }
    //
    $('#modalEditLanguage').modal('hide');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'edit_language',
            language: $('#e_language').val(),
            language_level: $('#e_language_level').val(),
            ml_id: $('#ml_id').val()
        },
        success: function (data) {
            finish_alert_update(data);
        }
    })
});
$('.delete-language').click(function(){
    var id = $(this).data('id');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'delete_language',
            id: id
        },
        success: function (data) {
            finish_alert_update(data);
        }
    });
});
$('#btnSaveAddWork').click(function () {
    if($.trim($('#w_title').val()) == '')
    {
        $('#w_title').addClass('error-input');
        $('.error-w_title').fadeIn();
        return false;
    }
    else
    {
        $('#w_title').removeClass('error-input');
        $('.error-w_title').hide();
    }
    if($.trim($('#w_company_name').val()) == '')
    {
        $('#w_company_name').addClass('error-input');
        $('.error-w_company_name').fadeIn();
        return false;
    }
    else
    {
        $('#w_company_name').removeClass('error-input');
        $('.error-w_company_name').hide();
    }
    if($.trim($('#w_from').val()) == '')
    {
        $('#w_from').addClass('error-input');
        $('.error-w_from').html('Không được để trống');
        $('.error-w_from').fadeIn();
        return false;
    }
    else if(!$('#w_from').val().match(/^(([0]{1,1}[1-9]{1,1})|([1]{1,1}[0-2]{1,1}))\/((20[0-9]{2,2})|(19[0-9]{2,2}))$/))
    {
        $('#w_from').addClass('error-input');
        $('.error-w_from').html('Vui lòng chọn đúng thời gian');
        $('.error-w_from').fadeIn();
        return false;
    }
    else
    {
        $('#w_from').removeClass('error-input');
        $('.error-w_from').hide();
    }
    //To
    var is_now = 0;
    if($('#w_now').is(':checked') == false)
    {
        is_now = 0;
        if($.trim($('#w_to').val()) == '')
        {
            $('#w_to').addClass('error-input');
            $('.error-w_to').html('Không được để trống');
            $('.error-w_to').fadeIn();
            return false;
        }
        else if(!$('#w_to').val().match(/^(([0]{1,1}[1-9]{1,1})|([1]{1,1}[0-2]{1,1}))\/((20[0-9]{2,2})|(19[0-9]{2,2}))$/))
        {
            $('#w_to').addClass('error-input');
            $('.error-w_to').html('Vui lòng chọn đúng thời gian');
            $('.error-w_to').fadeIn();
            return false;
        }
        else
        {
            $('#w_to').removeClass('error-input');
            $('.error-w_to').hide();
        }
    }
    else
    {
        is_now = 1;
        $('#w_to').removeClass('error-input');
        $('.error-w_to').hide();
    }
    //
    $(this).html('<i class="fa fa-spin fa-spinner"></i> Đang lưu');
    $('#modalAddWork').modal('hide');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'add_work',
            title: $('#w_title').val(),
            company_name: $('#w_company_name').val(),
            from: $('#w_from').val(),
            to: $('#w_to').val(),
            summary: $('#w_summary').val(),
            is_now: is_now
        },
        success: function (data) {
            finish_alert_update(data);
        }
    })
});
$('#w_now').click(function () {
    if($(this).is(':checked') == true)
    {
        $('#w_to').val('');
        $('#w_to').prop('readonly', true);
        $('#w_to').prop('disabled', 'disabled');
    }
    else
    {
        $('#w_to').removeAttr('disabled');
        $('#w_to').prop('readonly', false);
    }
});
$('.delete-work').on('click', function () {
    var id = $(this).data('id');
    if(id != '')
    {
        $.ajax({
            url: '/members/update_resume_ajax',
            type: 'post',
            dataType: 'json',
            data: {
                action: 'delete_work',
                id: id
            },
            success: function (data) {
                if(data)
                {
                    finish_alert_update(data);
                }
            }
        })
    }
});
$('.edit-work').click(function(){
    var title = $(this).data('title');
    var company = $(this).data('company_name');
    var from = $(this).data('from');
    var to = $(this).data('to');
    var summary = $(this).data('summary');
    var id = $(this).data('id');
    var is_now = $(this).data('is_now');
    $('#e_w_id').val(id);
    $('#e_w_title').val(title);
    $('#e_w_company_name').val(company);
    $('#e_w_from').val(from);
    $('#e_w_to').val(to);
    $('#e_w_summary').val(summary);
    if(is_now == 1)
    {
        $('#e_w_now').prop('checked', true);
        $('#e_w_to').val('');
        $('#e_w_to').prop('readonly', true);
        $('#e_w_to').prop('disabled', 'disabled');
    }
    else
    {
        $('#e_w_now').prop('checked', false);
        $('#e_w_to').removeAttr('disabled');
        $('#e_w_to').prop('readonly', false);
    }
    $('#modalEditWork').modal('show');
});
$('#e_w_now').click(function () {
    if($(this).is(':checked') == true)
    {
        $('#e_w_to').val('');
        $('#e_w_to').prop('readonly', true);
        $('#e_w_to').prop('disabled', 'disabled');
    }
    else
    {
        $('#e_w_to').removeAttr('disabled');
        $('#e_w_to').prop('readonly', false);
    }
});
$('#btnSaveEditWork').click(function () {
    if($.trim($('#e_w_title').val()) == '')
    {
        $('#e_w_title').addClass('error-input');
        $('.error-e_w_title').fadeIn();
        return false;
    }
    else
    {
        $('#e_w_title').removeClass('error-input');
        $('.error-e_w_title').hide();
    }
    if($.trim($('#e_w_company_name').val()) == '')
    {
        $('#e_w_company_name').addClass('error-input');
        $('.error-e_w_company_name').fadeIn();
        return false;
    }
    else
    {
        $('#e_w_company_name').removeClass('error-input');
        $('.error-e_w_company_name').hide();
    }
    if($.trim($('#e_w_from').val()) == '')
    {
        $('#e_w_from').addClass('error-input');
        $('.error-e_w_from').html('Không được để trống');
        $('.error-e_w_from').fadeIn();
        return false;
    }
    else if(!$('#e_w_from').val().match(/^(([0]{1,1}[1-9]{1,1})|([1]{1,1}[0-2]{1,1}))\/((20[0-9]{2,2})|(19[0-9]{2,2}))$/))
    {
        $('#e_w_from').addClass('error-input');
        $('.error-e_w_from').html('Vui lòng chọn đúng thời gian');
        $('.error-e_w_from').fadeIn();
        return false;
    }
    else
    {
        $('#e_w_from').removeClass('error-input');
        $('.error-e_w_from').hide();
    }
    //To
    var is_now = 0;
    if($('#e_w_now').is(':checked') == false)
    {
        is_now = 0;
        if($.trim($('#e_w_to').val()) == '')
        {
            $('#e_w_to').addClass('error-input');
            $('.error-e_w_to').html('Không được để trống');
            $('.error-e_w_to').fadeIn();
            return false;
        }
        else if(!$('#e_w_to').val().match(/^(([0]{1,1}[1-9]{1,1})|([1]{1,1}[0-2]{1,1}))\/((20[0-9]{2,2})|(19[0-9]{2,2}))$/))
        {
            $('#w_to').addClass('error-input');
            $('.error-e_w_to').html('Vui lòng chọn đúng thời gian');
            $('.error-e_w_to').fadeIn();
            return false;
        }
        else
        {
            $('#e_w_to').removeClass('error-input');
            $('.error-e_w_to').hide();
        }
    }
    else
    {
        is_now = 1;
        $('#e_w_to').removeClass('error-input');
        $('.error-e_w_to').hide();
    }
    //
    $(this).html('<i class="fa fa-spin fa-spinner"></i> Đang lưu');
    $('#modalEditWork').modal('hide');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'update_work',
            title: $('#e_w_title').val(),
            company_name: $('#e_w_company_name').val(),
            from: $('#e_w_from').val(),
            to: $('#e_w_to').val(),
            summary: $('#e_w_summary').val(),
            is_now: is_now,
            id: $('#e_w_id').val()
        },
        success: function (data) {
            if(data)
            {
                finish_alert_update(data);
            }
        }
    })
});
$('#btnSaveAddDegree').click(function () {
    if($.trim($('#d_specialized').val()) == '')
    {
        $('#d_specialized').addClass('error-input');
        $('.error-d_specialized').fadeIn();
        return false;
    }
    else
    {
        $('#d_specialized').removeClass('error-input');
        $('.error-d_specialized').hide();
    }
    if($.trim($('#d_school').val()) == '')
    {
        $('#d_school').addClass('error-input');
        $('.error-d_school').fadeIn();
        return false;
    }
    else
    {
        $('#d_school').removeClass('error-input');
        $('.error-d_school').hide();
    }
    if($.trim($('#d_degree').val()) == '')
    {
        $('#d_degree').addClass('error-input');
        $('.error-d_degree').fadeIn();
        return false;
    }
    else
    {
        $('#d_degree').removeClass('error-input');
        $('.error-d_degree').hide();
    }
    if($.trim($('#d_from').val()) == '')
    {
        $('#d_from').addClass('error-input');
        $('.error-d_from').html('Không được để trống');
        $('.error-d_from').fadeIn();
        return false;
    }
    else if(!$('#d_from').val().match(/^(([0]{1,1}[1-9]{1,1})|([1]{1,1}[0-2]{1,1}))\/((20[0-9]{2,2})|(19[0-9]{2,2}))$/))
    {
        $('#d_from').addClass('error-input');
        $('.error-d_from').html('Vui lòng chọn đúng thời gian');
        $('.error-d_from').fadeIn();
        return false;
    }
    else
    {
        $('#d_from').removeClass('error-input');
        $('.error-d_from').hide();
    }
    //To
    if($.trim($('#d_to').val()) == '')
    {
        $('#d_to').addClass('error-input');
        $('.error-d_to').html('Không được để trống');
        $('.error-d_to').fadeIn();
        return false;
    }
    else if(!$('#d_to').val().match(/^(([0]{1,1}[1-9]{1,1})|([1]{1,1}[0-2]{1,1}))\/((20[0-9]{2,2})|(19[0-9]{2,2}))$/))
    {
        $('#d_to').addClass('error-input');
        $('.error-d_to').html('Vui lòng chọn đúng thời gian');
        $('.error-d_to').fadeIn();
        return false;
    }
    else
    {
        $('#w_to').removeClass('error-input');
        $('.error-w_to').hide();
    }
    //
    $(this).html('<i class="fa fa-spin fa-spinner"></i> Đang lưu');
    $('#modalAddDegree').modal('hide');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'add_degree',
            specialized: $('#d_specialized').val(),
            school: $('#d_school').val(),
            from: $('#d_from').val(),
            to: $('#d_to').val(),
            degree: $('#d_degree').val(),
        },
        success: function (data) {
            finish_alert_update(data);
        }
    })
});
$('.delete-degree').on('click', function () {
    var id = $(this).data('id');
    if(id != '')
    {
        $.ajax({
            url: '/members/update_resume_ajax',
            type: 'post',
            dataType: 'json',
            data: {
                action: 'delete_degree',
                id: id
            },
            success: function (data) {
                if(data)
                {
                    finish_alert_update(data);
                }
            }
        })
    }
});
$('.edit-degree').click(function(){
    var specialized = $(this).data('specialized');
    var school = $(this).data('school');
    var degree = $(this).data('degree');
    var to = $(this).data('to');
    var from = $(this).data('from');
    var id = $(this).data('id');
    $('#ed_id').val(id);
    $('#ed_specialized').val(specialized);
    $('#ed_school').val(school);
    $('#ed_degree').val(degree).trigger('change');
    $('#ed_from').val(from);
    $('#ed_to').val(to);
    $('#modalEditDegree').modal('show');
});
$('#btnSaveEditDegree').click(function () {
    if($.trim($('#ed_specialized').val()) == '')
    {
        $('#ed_specialized').addClass('error-input');
        $('.error-ed_specialized').fadeIn();
        return false;
    }
    else
    {
        $('#ed_specialized').removeClass('error-input');
        $('.error-ed_specialized').hide();
    }
    if($.trim($('#ed_school').val()) == '')
    {
        $('#ed_school').addClass('error-input');
        $('.error-ed_school').fadeIn();
        return false;
    }
    else
    {
        $('#ed_school').removeClass('error-input');
        $('.error-ed_school').hide();
    }
    if($.trim($('#ed_degree').val()) == '')
    {
        $('#ed_degree').addClass('error-input');
        $('.error-ed_degree').fadeIn();
        return false;
    }
    else
    {
        $('#ed_degree').removeClass('error-input');
        $('.error-ed_degree').hide();
    }
    if($.trim($('#ed_from').val()) == '')
    {
        $('#ed_from').addClass('error-input');
        $('.error-ed_from').html('Không được để trống');
        $('.error-ed_from').fadeIn();
        return false;
    }
    else if(!$('#ed_from').val().match(/^(([0]{1,1}[1-9]{1,1})|([1]{1,1}[0-2]{1,1}))\/((20[0-9]{2,2})|(19[0-9]{2,2}))$/))
    {
        $('#ed_from').addClass('error-input');
        $('.error-ed_from').html('Vui lòng chọn đúng thời gian');
        $('.error-ed_from').fadeIn();
        return false;
    }
    else
    {
        $('#ed_from').removeClass('error-input');
        $('.error-ed_from').hide();
    }
    //To
    if($.trim($('#ed_to').val()) == '')
    {
        $('#ed_to').addClass('error-input');
        $('.error-ed_to').html('Không được để trống');
        $('.error-ed_to').fadeIn();
        return false;
    }
    else if(!$('#ed_to').val().match(/^(([0]{1,1}[1-9]{1,1})|([1]{1,1}[0-2]{1,1}))\/((20[0-9]{2,2})|(19[0-9]{2,2}))$/))
    {
        $('#d_to').addClass('error-input');
        $('.error-ed_to').html('Vui lòng chọn đúng thời gian');
        $('.error-ed_to').fadeIn();
        return false;
    }
    else
    {
        $('#ew_to').removeClass('error-input');
        $('.error-ew_to').hide();
    }
    //
    $(this).html('<i class="fa fa-spin fa-spinner"></i> Đang lưu');
    $('#modalEditDegree').modal('hide');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'update_degree',
            specialized: $('#ed_specialized').val(),
            school: $('#ed_school').val(),
            from: $('#ed_from').val(),
            to: $('#ed_to').val(),
            degree: $('#ed_degree').val(),
            id: $('#ed_id').val(),
        },
        success: function (data) {
            finish_alert_update(data);

        }
    })
});
$('#btnSaveAddRefer').click(function () {
    if($.trim($('#r_fullname').val()) == '')
    {
        $('#r_fullname').addClass('error-input');
        $('.error-r_fullname').fadeIn();
        return false;
    }
    else
    {
        $('#r_fullname').removeClass('error-input');
        $('.error-r_fullname').hide();
    }
    if($.trim($('#r_title').val()) == '')
    {
        $('#r_title').addClass('error-input');
        $('.error-r_title').fadeIn();
        return false;
    }
    else
    {
        $('#r_title').removeClass('error-input');
        $('.error-r_title').hide();
    }
    if($.trim($('#r_company').val()) == '')
    {
        $('#r_company').addClass('error-input');
        $('.error-r_company').fadeIn();
        return false;
    }
    else
    {
        $('#r_company').removeClass('error-input');
        $('.error-r_company').hide();
    }
    if($.trim($('#r_email').val()) != '')
    {
        if(!$('#r_email').val().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/))
        {
            $('#r_email').addClass('error-input');
            $('.error-r_email').html('Nhập đúng email');
            $('.error-r_email').fadeIn();
            return false;
        }
        else
        {
            $('#r_email').removeClass('error-input');
            $('.error-r_email').hide();
        }
    }
    //To

    //
    $(this).html('<i class="fa fa-spin fa-spinner"></i> Đang lưu');
    $('#modalAddRefer').modal('hide');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'add_refer',
            fullname: $('#r_fullname').val(),
            title: $('#r_title').val(),
            company: $('#r_company').val(),
            email: $('#r_email').val(),
            phone: $('#r_phone').val(),
        },
        success: function (data) {
            finish_alert_update(data);
        }
    })
});
$('.delete-refer').on('click', function(){
    var id = $(this).data('id');
    if(id != '')
    {
        $.ajax({
            url: '/members/update_resume_ajax',
            type: 'post',
            dataType: 'json',
            data: {
                action: 'delete_refer',
                id: id
            },
            success: function (data) {
                finish_alert_update(data);
            }
        })
    }
});
$('.edit-refer').click(function(){
    var fullname = $(this).data('fullname');
    var title = $(this).data('title');
    var company = $(this).data('company');
    var email = $(this).data('email');
    var phone = $(this).data('phone');
    var id = $(this).data('id');
    $('#er_id').val(id);
    $('#er_fullname').val(fullname);
    $('#er_title').val(title);
    $('#er_company').val(company);
    $('#er_email').val(email);
    $('#er_phone').val(phone);
    $('#modalEditRefer').modal('show');
});
$('#btnSaveEditRefer').click(function () {
    if($.trim($('#er_fullname').val()) == '')
    {
        $('#er_fullname').addClass('error-input');
        $('.error-er_fullname').fadeIn();
        return false;
    }
    else
    {
        $('#er_fullname').removeClass('error-input');
        $('.error-er_fullname').hide();
    }
    if($.trim($('#er_title').val()) == '')
    {
        $('#er_title').addClass('error-input');
        $('.error-er_title').fadeIn();
        return false;
    }
    else
    {
        $('#er_title').removeClass('error-input');
        $('.error-er_title').hide();
    }
    if($.trim($('#er_company').val()) == '')
    {
        $('#er_company').addClass('error-input');
        $('.error-er_company').fadeIn();
        return false;
    }
    else
    {
        $('#er_company').removeClass('error-input');
        $('.error-er_company').hide();
    }
    if($.trim($('#er_email').val()) != '')
    {
        if(!$('#er_email').val().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/))
        {
            $('#er_email').addClass('error-input');
            $('.error-er_email').html('Nhập đúng email');
            $('.error-er_email').fadeIn();
            return false;
        }
        else
        {
            $('#er_email').removeClass('error-input');
            $('.error-er_email').hide();
        }
    }
    //To

    //
    $(this).html('<i class="fa fa-spin fa-spinner"></i> Đang lưu');
    $('#modalEditRefer').modal('hide');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'update_refer',
            fullname: $('#er_fullname').val(),
            title: $('#er_title').val(),
            company: $('#er_company').val(),
            email: $('#er_email').val(),
            phone: $('#er_phone').val(),
            id: $('#er_id').val(),
        },
        success: function (data) {
            finish_alert_update(data);
        }
    })
});
//Desire
$('.chk-benefit').click(function(){
    var checked = 0;
    $('.chk-benefit').each(function (index, element) {
        if($('.chk-benefit:eq(' + index + ')').is(':checked') == true)
        {
            checked = checked + 1;
        }
    });
    if(checked > 5)
    {
        $(this).prop('checked', false);
        $('.error-desire_benefit').html('Không chọn quá 5 phúc lợi');
        $('.error-desire_benefit').fadeIn();
    }
    else
    {
        $('.error-desire_benefit').hide();
    }
    if($(this).is(':checked') == true)
    {
        $(this).next().addClass('span-selected');
    }
    else
    {
        $(this).next().removeClass('span-selected');
    }
});
$('#btnSaveEditDesire').click(function () {
    var desire_job = $('#desire_job').val();
    var desire_province = $('#desire_province').val();
    var desire_level = $('#desire_level').val();
    var desire_salary = $('#desire_salary').val();
    if(desire_job == null)
    {
        $('.error-desire_job').html('Chọn ngành nghề mong muốn');
        $('.error-desire_job').fadeIn();
        return false;
    }
    else if(desire_job.length > 3)
    {
        $('.error-desire_job').html('Chọn không quá 3 ngành nghề');
        $('.error-desire_job').fadeIn();
        return false;
    }
    else
    {
        $('.error-desire_job').hide();
    }
    if(desire_province == null)
    {
        $('.error-desire_province').html('Chọn nơi làm việc mong mưốn');
        $('.error-desire_province').fadeIn();
        return false;
    }
    else if(desire_province.length > 3)
    {
        $('.error-desire_province').html('Chọn không quá 3 nơi làm việc');
        $('.error-desire_province').fadeIn();
        return false;
    }
    else
    {
        $('.error-desire_province').hide();
    }
    if(desire_level == '')
    {
        $('.error-desire_level').fadeIn();
        return false;
    }
    else
    {
        $('.error-desire_level').hide();
    }
    //
    if(desire_salary == '')
    {
        $('.error-desire_salary').fadeIn();
        return false;
    }
    else
    {
        $('.error-desire_salary').hide();
    }
    //
    var checked = 0;
    $('.chk-benefit').each(function (index, element) {
        if($('.chk-benefit:eq(' + index + ')').is(':checked') == true)
        {
            checked = checked + 1;
        }
    });
    if(checked > 5)
    {
        $('.error-desire_benefit').html('Không chọn quá 5 phúc lợi');
        $('.error-desire_benefit').fadeIn();
        return false;
    }
    else
    {
        $('.error-desire_benefit').hide();
    }
    var desire_benefit = $('.chk-benefit:checkbox:checked').map(function() {
        return this.value;
    }).get();
    //
    $(this).html('<i class="fa fa-spin fa-spinner"></i> Đang lưu');
    $('#modalEditDesire').modal('hide');
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'update_desire',
            desire_job: desire_job,
            desire_province: desire_province,
            desire_level: desire_level,
            desire_salary: desire_salary,
            desire_benefit: desire_benefit
        },
        success: function(data){
            finish_alert_update(data);
        }
    })

});
$('#ckhAllowSearch').click(function () {
    var allow = 0;
    if($(this).is(':checked') == true)
    {
        allow = 1;
    }
    $.ajax({
        url: '/members/update_resume_ajax',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'allow_search',
            allow_search: allow
        },
        success: function (data) {
            finish_alert_update(data);
        }
    });
});
function finish_alert_update(data) {
    if(data.status == 'success')
    {
        alert_full('success', 'Đã cập nhật');
        setTimeout(function () {
            window.location = window.location;
        }, 1000);
    }
    else if(data.status == 'fail')
    {
        alert_full('error', 'Lỗi');
        setTimeout(function () {
            window.location = window.location;
        }, 1000);
    }
    else if(data.status == 'exist')
    {
        alert_full('warning', 'Đã tồn tại');
        setTimeout(function () {
            window.location = window.location;
        }, 1000);
    }
    else
    {
        window.location = window.location;
    }

}