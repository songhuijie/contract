        layui.config({base: '/xianshangke/modul/common/'}).use(['table', 'dialog', 'his'], function(){
    var table = layui.table
        ,dialog = layui.dialog
        ,his = layui.his
        ,$ = layui.$;

    table.render({
        elem: '#breach'
        ,url: '/admin/breach/list' //数据接口
        ,method: 'post'
        ,page: true //开启分页
        ,limit: 10
        ,limits: [10, 20]
        ,cols: [[ //表头
            {field: 'id', title: 'ID', sort: true, fixed: 'left', align: 'left'}
            ,{field: 'executor_name', title: '被执行人名'}
            ,{field: 'sex', title: '性别'}
            ,{field: 'age', title: '年龄',align:'center',templet:function(d){
                    if(d.age==2){
                        return '<a>女</a>';
                    }else{
                        return '<a>男</a>';
                    }
            }}
            ,{field: 'ID_card', title: '身份证号'}
            ,{field: 'province', title: '省份'}
            ,{field: 'executor_court', title: '执行法院'}
            ,{field: 'case_number', title: '案号'}
            ,{field: 'register_time', title: '立案时间'}
            // ,{field: 'symbol_number', title: '执行依据文号'}
            // ,{field: 'execution_unit', title: '做出执行依据单位'}
            // ,{field: 'performance', title: '生效法律文书确定的义务'}
            // ,{field: 'circumstances', title: '失信执行人行为具体情况'}
            // ,{field: 'release_time', title: '发布时间'}
            ,{title: '操作', width:200,toolbar: '#op'}


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
            var url = '/admin/breach/'+data.id+'/edit';
            layer.open({
                title:"编辑失信",
                type: 2,
                area: ['80%', '80%'],
                content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
            });

        } else if (layEvent == 'del') {
            dialog.confirm('确认删除改失信么', function () {
                var loadIndex = dialog.load('删除中，请稍候');
                his.ajax({
                    url: '/admin/breach/'+data.id
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
        table.reload('breach', query);
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

        var url = '/admin/breach/create';
        layer.open({
            title:"添加失信",
            type: 2,
            area: ['80%', '80%'],
            content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        });
    });

});