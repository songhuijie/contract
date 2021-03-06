        layui.config({base: '/xianshangke/modul/common/'}).use(['table', 'dialog', 'his'], function(){
    var table = layui.table
        ,dialog = layui.dialog
        ,his = layui.his
        ,$ = layui.$;


    table.render({
        elem: '#refund'
        ,url: '/admin/refund/list' //数据接口
        ,method: 'post'
        ,page: true //开启分页
        ,limit: 10
        ,limits: [10, 20]
        ,cols: [[ //表头
            {field: 'id', title: 'ID', sort: true, fixed: 'left', align: 'left'}
            ,{field: 'user_id', title: '用户ID'}
            ,{title:'用户名',templet:"<div>{{d.user_name.name}}</div>"}
            ,{field: 'price', title: '订单价格'}
            ,{field: 'order_number', title: '订单号'}
            ,{field:'status',title: '状态', width:100,align:'center',templet:function(d){
                    if(d.status==0){
                        return '<a>退款申请中</a>';
                    }else if(d.status == 1){
                        return '<a>退款中</a>';
                    }else if(d.status == 2){
                        return '<a>退款成功</a>';
                    }else{
                        return '<a>退款拒绝</a>';
                    }
            }}
            ,{field: 'created_at', title: '退款申请时间'}
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
            var url = '/admin/refund/'+data.id+'/edit';
            layer.open({
                title:"编辑退款申请",
                type: 2,
                area: ['80%', '80%'],
                content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
            });

        } else if (layEvent == 'del') {
            dialog.confirm('确认删除退款申请么', function () {
                layer.msg('暂不支持该功能');
                // var loadIndex = dialog.load('删除中，请稍候');
                // his.ajax({
                //     url: '/admin/refund/'+data.id
                //     ,type: 'delete'
                //     ,complete: function () {
                //         dialog.close(loadIndex);
                //     }
                //     ,error: function (msg) {
                //         dialog.error(msg);
                //     }
                //     ,success: function () {
                //         dialog.msg('删除成功');
                //         obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                //     }
                // });
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
        table.reload('refund', query);
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
        // var url = '/admin/refund/create';
        // layer.open({
        //     title:"添加退款申请",
        //     type: 2,
        //     area: ['80%', '80%'],
        //     content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        // });
    });

});