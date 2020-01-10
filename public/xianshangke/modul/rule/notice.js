        layui.config({base: '/xianshangke/modul/common/'}).use(['table', 'dialog', 'his'], function(){
    var table = layui.table
        ,dialog = layui.dialog
        ,his = layui.his
        ,$ = layui.$;

    table.render({
        elem: '#notice'
        ,url: '/admin/notice/list' //数据接口
        ,method: 'post'
        ,page: true //开启分页
        ,limit: 10
        ,limits: [10, 20]
        ,cols: [[ //表头
            {field: 'id', title: 'ID', sort: true, fixed: 'left', align: 'left'}
            ,{field: 'title', title: '标题'}
            ,{field: 'content', title: '内容'}
            ,{field:'status',title: '状态', width:100,align:'center',templet:function(d){
                    if(d.status==0){
                        return '<a>未查看</a>';
                    }else{
                        return '<a>查看</a>';
                    }
                }}
            ,{field: 'created_at', title: '时间'}
            ,{title: '操作', toolbar: '#op'}
        ]]
        ,response: {
            statusName: 'code'
            ,statusCode: 0
            ,msgName: 'msg'
            ,countName: 'meta'
            ,dataName: 'data'
        }
//				,skin: 'row' // 'line', 'row', 'nob'
        ,even: false //开启隔行背景
//                ,size: 'lg' // 'sm', 'lg'

    });

    table.on('tool(usertab)', function(obj){
        var data = obj.data;      //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr;          //获得当前行 tr 的DOM对象

        if (layEvent == 'active') {
            
        } else if (layEvent == 'edit') {
            layer.msg('暂不支持该功能');
            // var url = '/admin/notice/'+data.id+'/edit';
            // layer.open({
            //     title:"编辑通知",
            //     type: 2,
            //     area: ['80%', '80%'],
            //     content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
            // });

        } else if (layEvent == 'del') {
            dialog.confirm('确认删除改通知么', function () {
                var loadIndex = dialog.load('删除中，请稍候');
                his.ajax({
                    url: '/admin/notice/'+data.id
                    ,type: 'delete'
                    ,complete: function () {
                        dialog.close(loadIndex);
                    }
                    ,error: function (msg) {
                        dialog.error(msg);
                    }
                    ,success: function () {
                        dialog.msg('删除成功');
                        obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                    }
                });
            })

        }

    });

    function flushTable (cond, sortObj) {
        var query = {
            where: {
                cond: cond
            }
            ,page: {
                curr: 1
            }
        };
        if (sortObj != null) {
            query.initSort = sortObj;
            query.where.sortField = sortObj.field;   // 排序字段
            query.where.order = sortObj.type;        //排序方式
        }
        table.reload('notice', query);
    }

    // 搜索
    $('.search_btn').click(function () {
        var cond = $('.search_input').val();
        flushTable(cond);
    });

    // 排序
    table.on('sort(usertab)', function (obj) {
        var cond = $('.search_input').val();
        flushTable(cond, obj);
    });

    $('.add_btn').click(function () {

        layer.msg('暂不支持该功能');
        // var url = '/admin/notice/create';
        // layer.open({
        //     title:"添加通知",
        //     type: 2,
        //     area: ['80%', '80%'],
        //     content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        // });
    });

});