<?php $__env->startSection("content"); ?>
	<form class="layui-form layui-form-pane" style="width:80%;">
		<div class="layui-form-item">
			<label class="layui-form-label">用户组名</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="name" value="<?php echo e($role->name); ?>" lay-verify="required" placeholder="请输入用户组名称">
			</div>
		</div>
		<input type="hidden" name="id" value="<?php echo e($role->id); ?>">
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit type="button" lay-filter="editRole">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
	<script type="text/javascript" src="<?php echo e(asset('/xianshangke/modul/rule/editRole.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("js"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.layout.modify", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/rule/editRole.blade.php ENDPATH**/ ?>