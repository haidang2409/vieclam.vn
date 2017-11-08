/**
 * Created by nhdang on 10/31/2017.
 */
// file: recruitments_saved
$(function () {
    $('.delete-saved').on('click', function () {
        var id = $(this).data('id');
        if(id != '')
        {
            $.ajax({
                url: '/members_recruitments/delete_saved_ajax',
                type: 'post',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    if(data.status == 'success')
                    {
                        alert_full('success', data.message);
                        setTimeout(function () {
                            window.location = window.location;
                        }, 1000);
                    }
                    else if(data.status == 'applied')
                    {
                        alert_full('warning', data.message);
                    }
                    else if(data.status == 'fail')
                    {
                        alert_full('error', data.message);
                    }
                    else if(data.status == 'not_login')
                    {
                        alert_full('warning', data.message);
                    }
                    else
                    {
                        window.location = window.location;
                    }
                }
            })
        }
    })
});

//File admin_footer
$('#sidebar-toggle-icon').click(function () {
    var st = $(this).data('st');
    if(st == '1')
    {
        $('#sidebar-toggle-icon').data('st', '1');
        $.post('/admin/staffs/set_status_menu',{'status': 'true'},function(data){});
    }
    else
    {
        $('#sidebar-toggle-icon').data('st', '0');
        $.post('/admin/staffs/set_status_menu',{'status': 'false'},function(data){});
    }
});
$('.btnOpenSearch').click(function () {
    $('.div-form-timkiem').toggle();
    var show = $('.btnOpenSearch').data('show');
    if(show == '1')
    {
        $('.btnOpenSearch').data('show', '0');
        $('.btnOpenSearch').html('<i class="fa fa-search"></i>')
    }
    else
    {
        $('.btnOpenSearch').data('show', '1');
        $('.btnOpenSearch').html('<i class="fa fa-remove"></i>')
    }
});
