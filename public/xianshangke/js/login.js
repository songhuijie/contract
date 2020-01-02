
$(function(){


    layui.use('layer', function(){
        var layer = layui.layer;
        $("#loginbtn").click((e)=>{
            e.preventDefault()
            if($("#username").val() == ''){
                layer.msg("请输入用户名", {time:1000})
            }else if($("#pwd").val() == ''){
                layer.msg("请输入密码",{time:1000})
            }else{

                var formObject = {};
                var formArray =$("#form").serializeArray();
                $.each(formArray,function(i,item){
                    formObject[item.name] = item.value;
                });
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

                $.ajax({
                    data:formObject,
                    type:"post",
                    datatype:"json",
                    url:"login",
                    success:function(res){
                        console.log(res);
                        if(res.status!=0){
                            layer.msg(res.msg,{icon:5});return false;
                        }else{
                            layer.msg(res.msg,{icon:1});

                            setTimeout(function(){
                                window.location.href = "/admin/index";
                            }, 1000);

                        }
                    }
                });

            }

        })

    });
});

