        layui.config({base: '/xianshangke/modul/common/'}).use(['table', 'dialog', 'his'], function(){
    var table = layui.table
        ,dialog = layui.dialog
        ,his = layui.his
        ,$ = layui.$;

    table.render({
        elem: '#contract'
        ,url: '/admin/contract/list' //数据接口
        ,method: 'post'
        ,page: true //开启分页
        ,limit: 10
        ,limits: [10, 20]
        ,cols: [[ //表头

            {field: 'id', title: 'ID', sort: true, fixed: 'left', align: 'left'}
            ,{field: 'user_id', title: '用户'}
            ,{field: 'specific_user_id', title: '指定用户'}
            ,{field: 'template_id', title: '模板ID'}
            ,{field: 'contract_title', title: '代写名称'}
            ,{field: 'contract_demand', title: '代写需求'}
            ,{field: 'is_sign', title: '签署'}
            ,{field:'contract_type',title: '合同类型', width:100,align:'center',templet:function(d){
                    if(d.contract_type==1){
                        return '<a>系统模板</a>';
                    }else{
                        return '<a>律师代写</a>';
                    }
            }}
            ,{field:'status',title: '状态', width:100,align:'center',templet:function(d){
                    if(d.status==0){
                        return '<a>待支付</a>';
                    }else if(d.status==1){
                        return '<a>支付成功</a>';
                    }else if(d.status==2){
                        return '<a>编写中</a>';
                    }else if(d.status==3){
                        return '<a>待确认</a>';
                    }else{
                        return '<a>完成</a>';
                    }
            }}
            ,{field:'create_time', title: '合同创建时间',templet:'<div>{{ layui.util.toDateString(d.create_time, "yyyy-MM-dd HH:mm:ss") }}</div>',minWidth:150}
            ,{field: 'price', title: '代写价格'}
            ,{field: 'updated_at', title: '更新时间'}
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
            var url = '/admin/contract/'+data.id+'/edit';
            layer.open({
                title:"编辑合同",
                type: 2,
                area: ['80%', '80%'],
                content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
            });

        } else if (layEvent == 'del') {
            dialog.confirm('确认删除改合同么', function () {
                var loadIndex = dialog.load('删除中，请稍候');
                his.ajax({
                    url: '/admin/contract/'+data.id
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

    function flushTable (cond,contract_type, sortObj) {
        var query = {
            where: {
                cond: cond,
                contract_type: contract_type
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
        table.reload('contract', query);
    }

    // 搜索
    $('.search_btn').click(function () {
        var cond = $('.search_input').val();
        var contract_type =$("#contract_type option:selected").val();

        flushTable(cond,contract_type);
    });


    // 排序
    table.on('sort(usertab)', function (obj) {
        var cond = $('.search_input').val();
        flushTable(cond, obj);
    });

    $('.add_btn').click(function () {

        var url = '/admin/contract/create';
        layer.open({
            title:"添加合同",
            type: 2,
            area: ['80%', '80%'],
            content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        });
    });

});