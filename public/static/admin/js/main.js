Common = {
    upload_one : function(id){
        var url = $(id).attr('url');
        layui.use('upload', function() {
            var upload = layui.upload;
            upload.render({
                elem: id
                , url: url
                , done: function (res) {
                    if (res.code > 0) {
                        return layer.msg('上传失败');
                    }else{
                        $('#demo1').attr('src',res.msg);
                        $('input[name="'+id.substr(1)+'"]').val(res.msg);
                    }
                }
            });
        })
    },
    upload_video_one : function(id){
        var url = $(id).attr('url');
        layui.use('upload', function() {
            var upload = layui.upload;
            upload.render({
                elem: id
                , url: url
                , accept: 'video'
                , done: function (res) {
                    if (res.code > 0) {
                        return layer.msg('上传失败');
                    }else{
                        $('#demo1').attr('src',res.msg);
                        $('input[name="'+id.substr(1)+'"]').val(res.msg);
                    }
                }
            });
        })
    },
    form_sumbit : function(lay,url){
        layui.use('form',function(){
            var form = layui.form
                layer = layui.layer;
            form.on('submit('+lay+')', function(data){
                console.log(data.field);
                $.post(url,data.field,function(r){
                    console.log(r);
                    var res = $.parseJSON(r);
                    if(res.code > 0){
                        layer.msg(res.msg,{icon:2});
                        if ( res.url ) {
                            parent.location.href = res.url;
                        }
                    }else{
                        if ( res.url ) {
                            parent.location.href = res.url;
                        } else if (parent.frameElement) {
                            parent.location.reload();
                        } else {
                            history.go(0);
                        }
                    }
                })
                return false;
            });
        })
    },
    del : function(){ //
        layui.use('layer', function() {
            var layer = layui.layer;
            $('[mark="del"]').on('click',function(){
                var url = $(this).attr('url')
                    ,title = $(this).attr('title');
                if(!title) title = '确定删除吗？';
                layer.confirm(title, {
                    btn: ['确定','取消']
                }, function(){
                    $.post(url,function(r){
                        var res = $.parseJSON(r);
                        if(res.code > 0){
                            layer.msg(res.msg,{icon:2});
                        }else{
                            if (parent.frameElement) {
                                parent.location.reload();
                            } else {
                                history.go(0);
                            }
                        }
                    })
                    return false;
                }, function(){});

            })

            $('[mark="delall"]').on('click',function(){
                var url = $(this).attr('url')
                    ,ID = []
                    ,title = $(this).attr('title');

                if(!title) title = '确定删除吗？';
                $('.layui-form-checked').each(function(){
                    ID.push($(this).attr('data-id'));
                })
                layer.confirm(title, {
                    btn: ['确定','取消']
                }, function(){
                    $.post(url,{id:ID},function(r){
                        var res = $.parseJSON(r);
                        if(res.code > 0){
                            return layer.msg(res.msg,{icon:2});
                        }else{
                            if (parent.frameElement) {
                                return parent.location.reload();
                            } else {
                                return history.go(0);
                            }
                        }
                    })
                }, function(){});

            })
        })
    },
    time : function() {
        layui.use('laydate', function() {
            var laydate = layui.laydate;
            //日期
            laydate.render({
                elem: '#start'
            });
            laydate.render({
                elem: '#end'
            })
        })
    },
    onoff : function(str,url){
        layui.use(['form','layer'], function() {
            var form = layui.form
                ,layer = layui.layer;
            form.on('switch('+str+')', function(data){
                var status = this.checked ? '0' : '1'
                    ,id = $(this).attr('data-id');
                $.post(url,{status:status,onoff:true,id:id},function(r){
                    var res = $.parseJSON(r);
                    if(res.code > 0) {
                        layer.msg(res.msg,{time:1000,icon:2},function(){
                            history.go(0);
                        });
                    }
                })
            });
        })

    }
}

Login = {
    init : function(){
        if(self.frameElement.tagName=="IFRAME"){
            return parent.location.reload();
        }
    }
}
