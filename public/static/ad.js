/**
 * Created by Administrator on 2019/3/4.
 */

var ad_id = $("[ad-type='ad']").attr('ad-id');
var ad_templet = parseInt($("[ad-type='ad']").attr('ad-templet'));

switch (ad_templet) {
    case 1:
        start_open(ad_id);
        break;
    case 2:
        left_pos(ad_id);
        break;
    case 3:
        right_pos(ad_id);
        break;
    case 4:
        bottom_pos(ad_id);
        break;
    case 5:
        common_pos(ad_id);
        break;
    case 6:
        other_pos(ad_id);
        break;
}



function start_open(ad_id){

    if (!getCookie('ad_start_time')) {
        $.ajaxSettings.async = false;
        $.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:ad_id},function(r){
            var res = $.parseJSON(r);

            if (res.code > 0) {
                console.log(res);
            } else {
                $('html').append(res.data.templet_content);
                var sc = 5;
                ref = setInterval(function(){
                    sc --;
                    if(sc==0){
                        $('#ad').remove();
                        clearInterval(ref);
                    }else{
                        $('#ad button').html('跳过'+sc);
                    }
                },1000);

                $('#ad button').click(function(){
                    $('#ad').remove();
                    clearInterval(ref);
                })
            }
        })
        $.ajaxSettings.async = true;
        setCookie('ad_start_time',Date.parse(new Date()),3600);
    }

}

function left_pos(ad_id){
    $.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:ad_id},function(r){
        var res = $.parseJSON(r);
        if (res.code > 0) {
            console.log(res);
        } else {
            $('body').append(res.data.templet_content);
            $('#ad_close').click(function(){
                $(this).parent('div').remove();
            })
        }
    })

}

function right_pos(ad_id){
    $.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:ad_id},function(r){
        var res = $.parseJSON(r);
        if (res.code > 0) {
            console.log(res);
        } else {
            $('body').append(res.data.templet_content);
            $('#ad_close').click(function(){
                $(this).parent('div').remove();
            })
        }
    })
}

function bottom_pos(ad_id){
    $.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:ad_id},function(r){
        var res = $.parseJSON(r);
        if (res.code > 0) {
            console.log(res);
        } else {
            $('body').append(res.data.templet_content);
            $('#ad_close').click(function(){
                $(this).parent('div').remove();
            })
        }
    })
}

function common_pos(ad_id){
    $.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:ad_id},function(r){
        var res = $.parseJSON(r);
        if (res.code > 0) {
            console.log(res);
        } else {
            $("[ad-type='ad']").after(res.data.templet_content);
        }
    })
}
function other_pos(ad_id){
    $.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:ad_id},function(r){
        var res = $.parseJSON(r);
        if (res.code > 0) {
            console.log(res);
        } else {
            $('body').append(res.data.templet_content);
        }
    })
}


function setCookie(c_name,value,expiredays)
{
    var exdate=new Date()
    exdate.setDate(exdate.getDate()+expiredays)
    document.cookie=c_name+ "=" +escape(value)+
        ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}

function getCookie(c_name)
{
    if (document.cookie.length>0)
    {
        c_start=document.cookie.indexOf(c_name + "=")
        if (c_start!=-1)
        {
            c_start=c_start + c_name.length+1
            c_end=document.cookie.indexOf(";",c_start)
            if (c_end==-1) c_end=document.cookie.length
            return unescape(document.cookie.substring(c_start,c_end))
        }
    }
    return ""
}

