/**
 * Created by nhdang on 10/11/2017.
 */
function alert_full(color_name, content) {
    var color = 'rgba(49,81,133,.92)';
    if(color_name == 'success')
    {
        color = 'rgba(89,131,75,.92)';
    }
    if(color_name == 'primary')
    {
        color = 'rgba(50,50,50,.92)';
    }
    if(color_name == 'warning')
    {
        color = 'rgba(190,112,31,.92)';
    }
    if(color_name == 'error')
    {
        color = 'rgba(153,40,18,.92)';
    }
    $('.alert-full').css('background-color', color);
    $('.alert-full .content').html(content);
    $('.alert-full').fadeIn();
    setTimeout(function () {
        $('.alert-full').fadeOut();
    }, 3000);
}
$(".navbar-toggle").on("click", function () {
    $(this).toggleClass("active");
});
$('#closeAlertFull').click(function () {
    $('.alert-full').fadeOut();
});
function format_num(element) {
    var n = parseInt(element.value.replace(/\D/g,''),10);
    if(!isNaN(n))
    {
        element.value = n.toLocaleString();
    }
}
