/**
 * Created by Administrator on 2019/3/4.
 */

var data_id = $("[ad-data-type='ad']").attr('ad-data-id');

$.post('http://ad.jianghuyouka.com/api/index/get_ad',{id:data_id},function(r){
    console.log(r);
})



function start_open(){

}

function left_pos(){

}

function right_pos(){

}

function bottom_pos(){

}

function common_pos(){

}