@extends("admin.layout.modify")

@section("content")
    <div id="wrapper" style="margin-top:20px;">
        <div id="page-wrapper">
            <form class="layui-form" >

                <div class="layui-form-item">
                    <label class="layui-form-label">配置key</label>
                    <div class="layui-input-block">
                        <input type="text" name="key" required  lay-verify="required"  placeholder="请输入配置key" autocomplete="off" class="layui-input" value="@if(!empty($config)){{$config->key}}@endif">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">描述</label>
                    <div class="layui-input-block">
                        <input type="text" name="describe" required  lay-verify="required"  placeholder="请输入key描述(作用)" autocomplete="off" class="layui-input" value="@if(!empty($config)){{$config->describe}}@endif">
                    </div>
                </div>

                @if(!empty($config))
                    @switch($config->key)
                        @case('aboutUs')
                            <div class="layui-form-item">
                                <label class="layui-form-label">值</label>
                                <div class="layui-input-block">
                                    <textarea name="value" id="qaContent" lay-verify="content">@if(!empty($config)){{$config->value}} @endif</textarea>
                                </div>
                            </div>
                        @break
                        @case('rotation')
                        <div class="layui-form-item">
                            <label class="layui-form-label">轮播图json格式</label>
                            <button type="button" class="layui-btn" id="test2">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                            <div id="img">
                                @if(!empty($config))
                                    @foreach(json_decode($config->value,true) as $key)
                                        <input type="text" value="{{$key}}" hidden name="value[]">
                                        <img  src="/{{$key}}"    width="20%" title="点击删除">
                                    @endforeach
                                @else
                                <!-- <input type="text" value="" hidden name="img[]"> -->
                                    <img   src=""  >
                                @endif
                            </div>
                        </div>
                        @break
                        @default
                            <div class="layui-form-item">
                                <label class="layui-form-label">值</label>
                                <div class="layui-input-block">
                                    <input type="text" name="value" required  lay-verify="required"  placeholder="请输入配置key的值" autocomplete="off" class="layui-input" value="@if(!empty($config)){{$config->value}}@endif">
                                </div>
                            </div>
                        @break
                    @endswitch
                @else
                    <div class="layui-form-item">
                        <label class="layui-form-label">值</label>
                        <div class="layui-input-block">
                            <input type="text" name="value" required  lay-verify="required"  placeholder="请输入配置key的值" autocomplete="off" class="layui-input" value="@if(!empty($config)){{$config->value}}@endif">
                        </div>
                    </div>
                @endif






                @if(!empty($config))
                    <input type="text" id="mold" hidden  value="edit" >
                    <input type="text" id="id" hidden value="{{$config->id}}" >
                @endif

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit="" lay-filter="formDemo">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>


        </div>


    </div>
    <script>
        //单击图片删除图片 【注册全局函数】
        $('#img').on('click','img',function(){
            console.log($(this));
            $(this).prev().remove();
            $(this).remove();
        });
    </script>
@endsection
@section("js")
    <script>

        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        layui.use(['util','form','laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element', 'slider','layedit'], function(){
            var laydate = layui.laydate //日期
                ,laypage = layui.laypage //分页
                ,layer = layui.layer //弹层
                ,table = layui.table //表格
                ,carousel = layui.carousel //轮播
                ,upload = layui.upload //上传
                ,element = layui.element //元素操作
                ,slider = layui.slider //滑块
            var layedit = layui.layedit;
            var form = layui.form;
//执行实例 多图上传
            upload.render({
                elem: '#test2'
                ,method: 'post'
                ,multiple: true //是否允许多文件上传。设置 true即可开启。不支持ie8/9
                ,url: '{{URL("file/img")}}' //上传接口
                ,done: function(index, upload){
                    //获取当前触发上传的元素，一般用于 elem 绑定 class 的情况，注意：此乃 layui 2.1.0 新增
                    if(index.code!=0){
                        layer.msg("上传错误",{icon:5});
                    }else{
                        layer.msg("上传成功",{icon:6});
                        img="/"+index.data;
                        $("#img").append('<input type="text" value="'+index.data+'" hidden name="value[]"><img src="'+img+'" name="value[]" width="20%">')
                    }
                }
            });

            layedit.set({
                uploadImage: {
                    url: '/layer/upload' //接口url
                    ,type: 'post' //默认post
                    ,multiple: true
                }
            });
            var editIndex = layedit.build('qaContent'); // 建立编辑器
            form.verify({
                content:function () {
                    layedit.sync(editIndex);
                }
            });
            //监听提交
            form.on('submit(formDemo)', function(data){

                var date=data.field;

                if(date.key==""||date.describe==""||date.value==""){
                    layer.msg("不能为空,请填写完整",{icon:5});return false;
                }

                if($("#mold").val()!=undefined){
                    // date.id=$("#id").val();

                    url = "/admin/config/"+$("#id").val();

                    $.ajax({
                        data:date,
                        type: 'put',
                        datatype:"json",
                        url:url,
                        success:function(res){
                            console.log(res);
                            if(res.code==0){
                                parent.layer.msg(res.msg);
                                setTimeout(function(){
                                    parent.layer.closeAll();
                                    parent.location.reload();
                                },1000)
                            }else{
                                parent.layer.msg(res.msg);
                            }

                        }
                    });
                }else{
                    $.ajax({
                        data:date,
                        type:"post",
                        datatype:"json",
                        url:"{{url('admin/config')}}",
                        success:function(res){
                            console.log(res);
                            if(res.code==0){
                                parent.layer.msg(res.msg);
                                setTimeout(function(){
                                    parent.layer.closeAll();
                                    parent.location.reload();
                                },1000)
                            }else{
                                parent.layer.msg(res.msg);
                            }

                        }
                    });
                }

                return false;
            });
            //底部信息
            // var footerTpl = lay('#footer')[0].innerHTML;
            // lay('#footer').html(layui.laytpl(footerTpl).render({}))
            // .removeClass('layui-hide');
        });
    </script>
    <script>

    </script>
@endsection





