/**
 * Created by Administrator on 2019/3/4.
 */

var data_id = $("[ad-data-type='ad']").attr('ad-data-id');

$.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:data_id},function(r){
    var res = $.parseJSON(r);
    if (res.code > 0) {
        console.log(res);
    } else {
        switch (res.data.templet_id) {
            case 1:
                start_open(res.data);
                break;
            case 2:
                left_pos(res.data);
                break;
            case 3:
                right_pos(res.data);
                break;
            case 4:
                bottom_pos(res.data);
                break;
            case 5:
                common_pos(res.data);
                break;
            case 6:
                other_pos(res.data);
                break;
        }
    }

})



function start_open(data){

}

function left_pos(data){
    $('body').append(data.templet_content);
}

function right_pos(data){

}

function bottom_pos(data){

}

function common_pos(data){

}
function other_pos(data){

}