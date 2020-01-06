<?php $__env->startSection("css"); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
	<link rel="stylesheet" href="<?php echo e(asset('/xianshangke/extra/treegrid/css/jquery.treegrid.css')); ?>" media="all" />
	<form class="layui-form layui-form-pane" style="width:80%;">
		<div class="layui-form-item">
			<label class="layui-form-label">用户组名</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="name" lay-verify="required" placeholder="请输入用户组名称">
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit type="button" lay-filter="addRole">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
	<script type="text/javascript" src="<?php echo asset('/xianshangke/modul/rule/addRole.js')?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("js"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.layout.modify", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\xianshangke\resources\views/admin/rule/addRole.blade.php ENDPATH**/ ?>