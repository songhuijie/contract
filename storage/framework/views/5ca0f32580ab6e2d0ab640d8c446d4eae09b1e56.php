<?php $__env->startSection("content"); ?>
	<div id="page-wrapper">

		<div class="row" style="width: 100%">
			<div class="col-lg-12">
				<div class="layui-form toolbar">
					<div class="layui-form-item">
						<div class="layui-inline">
							<label class="layui-form-label w-auto">搜索：</label>
							<div class="layui-input-inline mr0">
								<input name="keyword" class="layui-input" type="text" placeholder="输入关键字"/>
							</div>
						</div>



						<div class="layui-inline">
							<button class="layui-btn icon-btn" lay-filter="formSubSearchRole" lay-submit>
								<i class="layui-icon">&#xe615;</i>搜索
							</button>
						</div>

					</div>
				</div>

				<table class="layui-hide" id="demo" lay-filter="test"></table>

				<div id="test1"></div>


				<script type="text/html" id="barDemo">
					<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
					<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
				</script>

				<script type="text/html" id="staDemo">
					
					{{#  if(d.status ==1){ }}
					<a class="layui-btn layui-btn-danger layui-btn-xs"  onclick="status({{d.id}})" lay-event="check">禁用</a>
					{{#  } }}

					{{#  if(d.status ==0){ }}
					<a class="layui-btn layui-btn-xs" onclick="status({{d.id}})" lay-event="check">启用</a>
					{{#  } }}
					
				</script>
				<script type="text/html" id="typeDemo">
					
					{{#  if(d.type ==1){ }}
					<a >会员标签</a>
					{{#  } }}

					{{#  if(d.type ==2){ }}
					<a >导游标签</a>
					{{#  } }}

					{{#  if(d.type ==3){ }}
					<a >评论标签</a>
					{{#  } }}
					
				</script>

				<script type="text/html" id="good_image">
					
					<img src="../{{d.good_image}}">
					
				</script>



			</div>
			<!-- /.col-lg-12 -->
		</div>

	</div>
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>

    <script>
        layui.config({
            version: '1568076536509' //为了更新 js 缓存，可忽略
        });

        layui.use(['util','form','laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element', 'slider'], function(){
            var laydate = layui.laydate //日期
                ,laypage = layui.laypage //分页
                ,layer = layui.layer //弹层
                ,table = layui.table //表格
                ,carousel = layui.carousel //轮播
                ,upload = layui.upload //上传
                ,element = layui.element //元素操作
                ,slider = layui.slider //滑块
            var form = layui.form;

            var insTb = table.render({
                elem: '#demo'
                ,height: 800
                ,url: '<?php echo e(URL("admin/users")); ?>?type=select' //数据接口
                ,title: '标签表'
                ,page: true //开启分页
                ,toolbar: 'default' //开启工具栏，此处显示默认图标，可以自定义模板，详见文档
                ,totalRow: true //开启合计行
                ,limit : 5 //这里设置的是每页显示多少条
                ,cols: [[ //表头
                    {type: 'checkbox', fixed: 'left'}

                    ,{field: 'id', title: 'ID', sort: true }
                    // ,{title: '类型', width:100,align:'center',toolbar: '#typeDemo'}
                    ,{field: 'username', title: '管理员名',align:'center'}
                    ,{field: 'tel', title: '手机', align:'center'}
                    ,{field: 'email', title: '邮箱',align:'center'}
                    ,{field: 'status', title: '状态',align:'center'}

                    ,{field:'status',title: '状态',align:'center',templet:function(d){
                        if(d.status==1){
                            return '<a>开启</a>';
                        }else{
                            return '<a>禁用</a>';
                        }
                    }}

                    // ,{field: 'time', title: '创建时间', width:180,align:'center',
                    //   templet: function (d) {
                    //     return layui.util.toDateString(d.time * 1000, "yyyy-MM-dd HH:mm:ss")
                    //   }
                    // }
                    // ,{ title: '分类', width:80,align:'center', toolbar: '#staDemo'}
                    ,{fixed: 'right',title:'操作', align:'center', toolbar: '#barDemo'}
                ]]
            });

            element.init();
            //搜索
            form.on('submit(formSubSearchRole)', function (data) {
                insTb.reload({where: data.field}, 'data');
            });

            //监听头工具栏事件
            table.on('toolbar(test)', function(obj){

                var checkStatus = table.checkStatus(obj.config.id)
                    ,data = checkStatus.data; //获取选中的数据
                switch(obj.event){
                    case 'add':
                        layer.open({
                            title:"添加",
                            type: 2,
                            area: ['80%', '80%'],
                            content: '<?php echo e(url("admin/user/create")); ?>' //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
                        });
                        //layer.msg('添加');
                        break;
                    case 'update':
                        if(data.length === 0){
                            layer.msg('请选择一行');
                        } else if(data.length > 1){
                            layer.msg('只能同时编辑一个');
                        } else {

                            layer.open({
                                title:"编辑",
                                type: 2,
                                area: ['80%', '80%'],
                                content: '<?php echo e(url("goods/detail")); ?>?type=edit&id='+data[0].id

                            });
                        }
                        break;
                    case 'delete':
                        if(data.length === 0){
                            layer.msg('请选择一行');
                        } else {
                            layer.alert('确定删除？', {
                                skin: 'layui-layer-molv' //样式类名  自定义样式
                                ,closeBtn: 1    // 是否显示关闭按钮
                                ,anim: 1 //动画类型
                                ,btn: ['确定','取消'] //按钮
                                ,icon: 6    // icon
                                ,yes:function(){
                                    del(data);
                                }
                                ,btn2:function(){
                                    layer.msg('已取消操作')
                                }});

                        }
                        break;
                };
            });

            //监听行工具事件
            table.on('tool(test)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'detail'){
                    layer.msg('查看操作');
                } else if(layEvent === 'del'){
                    layer.alert('确定删除？', {
                        skin: 'layui-layer-molv' //样式类名  自定义样式
                        ,closeBtn: 1    // 是否显示关闭按钮
                        ,anim: 1 //动画类型
                        ,btn: ['确定','取消'] //按钮
                        ,icon: 6    // icon
                        ,yes:function(){
                            del(data);
                        }
                        ,btn2:function(){
                            layer.msg('已取消操作')
                        }});
                } else if(layEvent === 'edit'){
                    layer.open({
                        title:"编辑",
                        type: 2,
                        area: ['80%', '80%'],
                        content: '<?php echo e(url("goods/detail")); ?>?type=edit&id='+obj.data.id //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']

                    });
                }
            });

            function del(data){
                if(data.length==undefined){
                    //单行删除
                    var id=data.id;
                }else{//多行删除
                    var id=[];
                    for(var i=0;i<data.length;i++){
                        id.push(data[i].id);
                    }
                }

                $.ajax({
                    type:"delete",
                    datatype:"json",
                    data:{'id':id},
                    url:"<?php echo e(url('admin/user')); ?>",
                    success:function(res){
                        console.log(res);
                        if(res.code==1){
                            layer.msg(res.msg);
                            window.location.reload();
                            setTimeout(function(){
                                window.location.reload();
                            },1000);
                        }else{
                            layer.msg(res.msg);
                        }
                    }

                });



            };

            //底部信息
            // var footerTpl = lay('#footer')[0].innerHTML;
            // lay('#footer').html(layui.laytpl(footerTpl).render({}))
            // .removeClass('layui-hide');

        });
        function status(id){
            $.ajax({
                data:{'id':id,'type':'edit'},
                type:'post',
                datatype:"json",
                url:"<?php echo e(url('admin/users')); ?>",
                success:function(res){
                    if(res.code==1){
                        layer.msg(res.msg,{icon:6});
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);
                    }else{
                        layer.msg(res.msg,{icon:5});
                    }
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("admin.layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\xianshangke\resources\views/admin/rule/users.blade.php ENDPATH**/ ?>