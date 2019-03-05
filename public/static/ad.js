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
    $.ajaxSettings.async = false;
    $.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:ad_id},function(r){
        var res = $.parseJSON(r);

        if (res.code > 0) {
            console.log(res);
        } else {
            $('html').append(res.data.templet_content);
            console.log(res.data.templet_content);
            var sc = 80;
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
}

function left_pos(ad_id){
    $.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:ad_id},function(r){
        var res = $.parseJSON(r);
        if (res.code > 0) {
            console.log(res);
        } else {
            $('body').append(res.data.templet_content);
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
        }
    })
}

function common_pos(ad_id){
    $.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:ad_id},function(r){
        var res = $.parseJSON(r);
        if (res.code > 0) {
            console.log(res);
        } else {
            $('body').append(res.data.templet_content);
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