@extends("admin.layout.modify")



@section("content")
    <link rel="stylesheet" href="{{asset('/xianshangke/extra/zTree/css/zTreeStyle.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('/xianshangke/modul/rule/setRules.css')}}" type="text/css">
    <div class="admin-main layui-anim layui-anim-upbit">
        <fieldset class="layui-elem-field">
            <legend>配置权限</legend>
            <div class="layui-field-box">
                <form class="layui-form layui-form-pane">
                    <ul id="treeDemo" class="ztree"></ul>
                    <div class="layui-form-item text-center">
                        <button type="button" class="layui-btn" lay-submit type="button" lay-filter="submit">提交</button>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>

    <script type="text/javascript" src="{{asset('/xianshangke/extra/zTree/js/jquery.ztree.core.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('xianshangke/extra/zTree/js/jquery.ztree.excheck.min.js')}}"></script>
    <script type="text/javascript">
        var setting = {
            check:{enable: true},
            view: {showLine: false, showIcon: false, dblClickExpand: false},
            data: {
                simpleData: {enable: true, pIdKey:'pid', idKey:'id'},
                key:{name:'title'}
            }
        };
        var zNodes = {!!$rules!!};
        function setCheck() {
            var zTree = $.fn.zTree.getZTreeObj("treeDemo");
            zTree.setting.check.chkboxType = { "Y":"ps", "N":"ps"};

        }
        $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        setCheck();
        layui.config({base: '/xianshangke/modul/common/'}).use(['form', 'dialog', 'his'], function () {
            var form = layui.form, dialog = layui.dialog, his = layui.his;
            form.on('submit(submit)', function () {
                var loadIndex = dialog.load('数据提交中，请稍候');
                // 提交到方法 默认为本身
                var treeObj = $.fn.zTree.getZTreeObj("treeDemo"),
                    nodes=treeObj.getCheckedNodes(true),
                    v=[];
                for(var i=0;i<nodes.length;i++){
                    v[i]=nodes[i].id;
                }
                var id = "{{$role_id}}";
                var token = '{{ csrf_token() }}';
                his.ajax({
                    url: '/admin/role/'+id+'/rules'
                    ,type: 'put'
                    ,data: {id: id, rules: v, _token: token}
                    ,contentType: 'form'
                    ,complete: function(){
                        dialog.close(loadIndex);
                    },
                    error: function(msg){
                        dialog.error(msg);
                    },
                    success: function(res){
                        dialog.msg("配置成功！");
                        dialog.closeAll('iframe');
                        parent.location.reload();
                    }
                });
                return false;
            })
        });
    </script>
@endsection

@section("js")

@endsection