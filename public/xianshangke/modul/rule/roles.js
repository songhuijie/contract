layui.config({base: '/xianshangke/modul/common/'}).use(['dialog','his'],function(){
    var dialog = layui.dialog,
        his = layui.his,
        $ = layui.$;

    //添加角色
    $(".role_add").click(function(){
        var url = "role/create";
        layer.open({
            title:"添加",
            type: 2,
            area: ['80%', '80%'],
            content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        });
    });

    //编辑用户组
    $("body").on("click",".role_edit",function(){  //编辑
        var id = $(this).attr('data-id');
        // dialog.open('编辑用户组', '/admin/role/'+id+'/edit');
        var url = 'role/'+id+'/edit';
        layer.open({
            title:"编辑用户组",
            type: 2,
            area: ['80%', '80%'],
            content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        });
    });

    //配置用户组权限
    $("body").on("click",".rule_set",function(){  //编辑
        var id = $(this).attr('data-id');
        // dialog.open('配置权限', '/admin/role/'+id+'/rules');

        var url = 'role/'+id+'/rules';
        layer.open({
            title:"配置权限",
            type: 2,
            area: ['80%', '80%'],
            content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        });
    });

    $("body").on("click",".role_del",function(){  //删除
        var _this = $(this);
        var id = $(this).attr('data-id');
        dialog.confirm('确定删除此信息？', function () {
            var loadIndex = dialog.load('删除中');
            his.ajax({
                url: '/admin/role'
                ,type: 'delete'
                ,data: {id: id}
                ,complete: function () {
                    dialog.close(loadIndex);
                }
                ,error: function(msg){
                    dialog.error(msg);
                },
                success: function(msg, data, meta){
                    _this.parents("tr").remove();
                    dialog.msg('删除成功');
                }
            });
        });
    })

})