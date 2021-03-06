        layui.config({base: '/xianshangke/modul/common/'}).use(['table', 'dialog', 'his'], function(){
    var table = layui.table
        ,dialog = layui.dialog
        ,his = layui.his
        ,$ = layui.$;

    table.render({
        elem: '#charter'
        ,url: '/admin/charter/list' //数据接口
        ,method: 'post'
        ,page: true //开启分页
        ,limit: 10
        ,limits: [10, 20]
        ,cols: [[ //表头
            {field: 'user_id', title: '用户ID', sort: true, fixed: 'left', align: 'left'}
            ,{field: 'name', title: '用户名/法人姓名'}
            ,{field: 'ID_card', title: '身份证号/法人身份证号'}
            ,{field: 'company_name', title: '公司名称'}
            ,{field: 'certificate_number', title: '证书编号'}
            ,{field: 'official_seal_number', title: '公章编号'}
            ,{field: 'business_license', title: '营业执照'}
            ,{ title: '印章图片', width:100,align:'center', toolbar: '#charter_pic'}
            ,{field:'charter_type',title: '个人/公司', width:100,align:'center',templet:function(d){
                    if(d.charter_type==1){
                        return '<a>个人</a>';
                    }else{
                        return '<a>公司</a>';
                    }
                }}
            // ,{title: '操作', toolbar: '#op'}
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
            var url = '/admin/charter/'+data.id+'/edit';
            layer.open({
                title:"编辑印章",
                type: 2,
                area: ['80%', '80%'],
                content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
            });

        } else if (layEvent == 'del') {
            dialog.confirm('确认删除改印章么', function () {
                var loadIndex = dialog.load('删除中，请稍候');
                his.ajax({
                    url: '/admin/charter/'+data.id
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
        table.reload('charter', query);
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

        var url = '/admin/charter/create';
        layer.open({
            title:"添加印章",
            type: 2,
            area: ['80%', '80%'],
            content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        });
    });
    $(".main-content").on("click","img",function(e){
        layer.photos({
            photos: { "data": [{"src": e.target.src}] }
        });
    });
});