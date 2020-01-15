        layui.config({base: '/xianshangke/modul/common/'}).use(['table', 'dialog', 'his'], function(){
    var table = layui.table
        ,dialog = layui.dialog
        ,his = layui.his
        ,$ = layui.$;

    table.render({
        elem: '#certification'
        ,url: '/admin/certification/list' //数据接口
        ,method: 'post'
        ,page: true //开启分页
        ,limit: 10
        ,limits: [10, 20]
        ,cols: [[ //表头
            {field: 'user_id', title: '用户ID', sort: true, fixed: 'left', align: 'left'}
            ,{field: 'name', title: '身份证姓名'}
            ,{field: 'ID_card', title: '身份证号'}
            ,{ title: '身份证正面图', width:100,align:'center', toolbar: '#identity_card_positive'}
            ,{ title: '身份证背面图', width:100,align:'center', toolbar: '#identity_card_back'}
            ,{field:'status',title: '审核状态', width:100,align:'center',templet:function(d){
                    if(d.status==0){
                        return '<a>待审核</a>';
                    }else if(d.status == 1){
                        return '<a>审核通过</a>';
                    }else{
                        return '<a>审核拒绝</a>';
                    }
                }}
            ,{field: 'updated_at', title: '时间'}
            ,{title: '操作', toolbar: '#barDemo'}
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

        if (layEvent == 'view') {
            var url = '/admin/certification/'+data.user_id;
            layer.open({
                title:"显示详细数据",
                type: 2,
                area: ['80%', '80%'],
                content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
            });
        } else if (layEvent == 'edit') {
            var url = '/admin/certification/'+data.user_id+'/edit';
            layer.open({
                title:"编辑实名",
                type: 2,
                area: ['80%', '80%'],
                content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
            });

        } else if (layEvent == 'del') {
            dialog.confirm('确认删除改实名么', function () {
                layer.msg('暂不支持该功能');
                // var loadIndex = dialog.load('删除中，请稍候');
                // his.ajax({
                //     url: '/admin/certification/'+data.id
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
        table.reload('certification', query);
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
        // var url = '/admin/certification/create';
        // layer.open({
        //     title:"添加实名",
        //     type: 2,
        //     area: ['80%', '80%'],
        //     content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        // });
    });

    $("body").on("click","img",function(e){
        layer.photos({
            photos: { "data": [{"src": e.target.src}] }
        });
    });
});
