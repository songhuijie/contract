<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title></title>
	<link href="<?php echo e(asset('assets/libs/layui/css/layui.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('page/table/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('page/table/vendor/metisMenu/metisMenu.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('page/table/vendor/datatables-plugins/dataTables.bootstrap.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('page/table/vendor/datatables-responsive/dataTables.responsive.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('page/table/dist/css/sb-admin-2.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('page/table/vendor/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css">


	<style>
		.page-header{
			border-bottom: none !important;
		}
		#page-wrapper{
			border-left: none !important;
		}
	</style>
</head>

<body>
	<div id="wrapper" style="margin-top:20px;">
		<div id="page-wrapper">
			<form class="layui-form" >

				<div class="layui-form-item">
					<label class="layui-form-label">用户组</label>
					<div class="layui-input-block">
						<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<input type="checkbox" class="user_group" name="role_id[]" title="<?php echo e($role->name); ?>" value="<?php echo e($role->id); ?>" <?php if($role && $role->checked == 1): ?><?php echo e('checked'); ?> <?php endif; ?>>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>

				<div class="layui-form-item">
					<label class="layui-form-label">用户名</label>
					<div class="layui-input-block">
						<input type="text" name="username" required  lay-verify="required"  placeholder="请输入用户名" autocomplete="off" class="layui-input" value="<?php if(!empty($admin)): ?><?php echo e($admin['username']); ?><?php endif; ?>">
					</div>
				</div>


				<div class="layui-form-item">
					<label class="layui-form-label">密码</label>
					<div class="layui-input-block">
						<input type="password" name="password" required  lay-verify="required"  placeholder="请输入密码" autocomplete="off" class="layui-input" value="<?php if(!empty($admin)): ?><?php echo e($admin['password']); ?><?php endif; ?>" readonly>
					</div>
				</div>

				<div class="layui-form-item">
					<label class="layui-form-label">确认密码</label>
					<div class="layui-input-block">
						<input type="password" name="password_confirmation" required  lay-verify="required"  placeholder="请输入确认密码" autocomplete="off" class="layui-input" value="<?php if(!empty($admin)): ?><?php echo e($admin['password']); ?> <?php endif; ?>" readonly >
					</div>
				</div>

				<div class="layui-form-item">
					<label class="layui-form-label">邮箱</label>
					<div class="layui-input-block">
						<input type="text" class="layui-input" name="email" lay-verify="email" placeholder="请输入邮箱" value="<?php if(!empty($admin)): ?><?php echo e($admin['email']); ?><?php endif; ?>" readonly>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">手机号</label>
					<div class="layui-input-block">
						<input type="text" class="layui-input" name="tel" lay-verify="required" placeholder="请输入手机号" value="<?php if(!empty($admin)): ?><?php echo e($admin['tel']); ?><?php endif; ?>" readonly>
					</div>
				</div>


				<?php if(!empty($admin)): ?>
					<input type="text" id="mold" hidden  value="edit" >
					<input type="text" id="id" hidden value="<?php echo e($admin['id']); ?>" >
				<?php endif; ?>

				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn" lay-submit="" lay-filter="formDemo">立即提交</button>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			</form>


		</div>


	</div>


	<script src="<?php echo e(asset('page/table/vendor/jquery/jquery.min.js')); ?>"></script>
	<!-- <script src="<?php echo e(asset('assets/libs/layui/lay/modules/jquery.js')); ?>"></script> -->
	<script src="<?php echo e(asset('page/table/vendor/bootstrap/js/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(asset('page/table/vendor/metisMenu/metisMenu.min.js')); ?>"></script>
	<script src="<?php echo e(asset('page/table/vendor/datatables/js/jquery.dataTables.min.js')); ?>"></script>
	<script src="<?php echo e(asset('page/table/vendor/datatables-plugins/dataTables.bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(asset('page/table/vendor/datatables-responsive/dataTables.responsive.js')); ?>"></script>
	<script src="<?php echo e(asset('page/table/dist/js/sb-admin-2.js')); ?>"></script>

	<script src="<?php echo e(asset('assets/libs/layui/layui.all.js')); ?>"></script>
	<!-- <script src="<?php echo e(asset('assets/libs/layui/layui.js')); ?>"></script> -->

	<script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
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
//执行实例 多图上传
            upload.render({
                elem: '#test2'
                ,method: 'post'
                ,multiple: true //是否允许多文件上传。设置 true即可开启。不支持ie8/9
                ,url: '<?php echo e(URL("file/img")); ?>' //上传接口
                ,done: function(index, upload){
                    //获取当前触发上传的元素，一般用于 elem 绑定 class 的情况，注意：此乃 layui 2.1.0 新增
                    if(index.code!=0){
                        layer.msg("上传错误",{icon:5});
                    }else{
                        layer.msg("上传成功",{icon:6});
                        img="../"+index.data;
                        $("#img2").append('<img src="'+img+'" name="img[]" width="20%"><input type="text" value="'+index.data+'" hidden name="rotation[]">')
                    }
                }
            });
            //监听提交
            form.on('submit(formDemo)', function(data){

                var date=data.field;

                if(date.types==""||date.label==""){
                    layer.msg("不能为空,请填写完整",{icon:5});return false;
                }
                date.type="add";
                if($("#mold").val()!=undefined){
                    date.update="update";
                    date.id=$("#id").val();
                    date.type="edit";
                }

                $.ajax({
                    data:date,
                    type:"post",
                    datatype:"json",
                    url:"<?php echo e(url('admin/user')); ?>",
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

                })
                return false;
            });
            //底部信息
            // var footerTpl = lay('#footer')[0].innerHTML;
            // lay('#footer').html(layui.laytpl(footerTpl).render({}))
            // .removeClass('layui-hide');
        });
	</script>

	</body>

	</html>


<?php /**PATH D:\phpstudy\WWW\html\xianshangke\xianshangke\resources\views/admin/rule/addUser.blade.php ENDPATH**/ ?>