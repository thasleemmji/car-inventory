var errColor = '#ef190e';//error color
var succColor = '#dadada';//success color
var customMsg = 'Something went wrong';

function notify(msg,type='error') {
    $.toast({text: msg,position: 'bottom-right',icon: type,hideAfter: 3000,stack: 1});
    return true;
}

function ajaxAlert(type,msg) {
    $("#Msg"+type).text(msg);
    $("#Alert"+type).slideDown().delay(3000).slideUp();
    return true;
}
function ajaxModalAlert(type,msg) {
    $("#Modal"+type).text(msg);
    $("#Modal"+type).slideDown().delay(3000).slideUp();
    return true;
}
function alphaValidate(str,field) {
    var aFormat = /^[A-Za-z]+$/;
    if (!str.match(aFormat)) {
        $("#"+field).css('borderColor',errColor);$("#"+field).focus();
        notify("Only aphabetic characters allowed [A-Z, a-z]");return false;
    }else {
        $("#"+field).css('borderColor',succColor);return true;
    }  
}
function nullValidate(value,field,msg=customMsg) {
    if(value=='') {
        $("#"+field).css('borderColor',errColor);$("#"+field).focus();
        notify(msg);return false;
    }else {
        $("#"+field).css('borderColor',succColor);return true;
    }  
}
function emailValidate(email,field) {
    var eFormat = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,8})+$/;
    if (!email.match(eFormat)) {
        $("#"+field).css('borderColor',errColor);$("#"+field).focus();
        notify("Enter a valid email address");return false;
    }else {
        $("#"+field).css('borderColor',succColor);return true;
    }  
}
function usernameValidate(username,field) {
    var uFormat = /^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/;
    if (!username.match(uFormat)) {
        $("#"+field).css('borderColor',errColor);$("#"+field).focus();
        notify("Enter a valid username");return false;
    }else {
        $("#"+field).css('borderColor',succColor);return true;
    }  
}

function fieldExist(val,inp,dbcol,tbl,msg,type=null) {
    var exist;
    $.ajax({
        async: false,
        url: burl+'/checkExist',
        type: 'POST',
        data: {type:type,value:val,table:tbl,field:dbcol},
        dataType: 'JSON',
        success: function (res) {
            if(res=='1') {//exist
                $("#"+inp).css('borderColor',errColor);$("#"+inp).focus();
                notify(msg);
                exist = false;
            }else {
                $("#"+inp).css('borderColor',succColor);
                exist = true;
            }
        }
    });
    return exist;
}
$('.datatable').DataTable({
    "responsive":true
});
$('.car-image').owlCarousel({
    center: true,
    items:1,
    loop:true,
    margin:10,
    nav:false,
    dots:false,
    autoplay:true,
    autoplayTimeout:3000,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut'
});
//customBox modal Initialization
$('[data-plugin="custommodal"]').on('click', function(e) {
    Custombox.open({
        target: $(this).attr("href"),
        effect: $(this).attr("data-animation"),
        overlaySpeed: $(this).attr("data-overlaySpeed"),
        overlayColor: $(this).attr("data-overlayColor")
    });
    e.preventDefault();
});