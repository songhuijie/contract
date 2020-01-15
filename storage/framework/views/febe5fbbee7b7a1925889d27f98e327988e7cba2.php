<?php $__env->startSection("content"); ?>
	<form class="layui-form layui-form-pane" style="width:80%;">
		<div class="layui-form-item">
			<label class="layui-form-label">父级</label>
			<div class="layui-input-block">
				<select name="pid">
					<option value="0">默认顶级</option>
					<?php $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option data-level="<?php echo e($vo['level']); ?>" value="<?php echo e($vo['id']); ?>" <?php if($vo['id'] == $rule->pid): ?> selected="selected" <?php endif; ?>><?php echo e($vo['ltitle']); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</select>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">权限名称</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="title" value="<?php echo e($rule->title); ?>" lay-verify="required" placeholder="请输入权限名称">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">链接</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="href" value="<?php echo e($rule->href); ?>" placeholder="/rules">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">控制器@方法</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="rule" value="<?php echo e($rule->rule); ?>" placeholder="RuleController@rules">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">图标</label>
			<div class="layui-input-inline">
				<input type="text" class="layui-input" name="icon" value="<?php echo e($rule->icon); ?>" placeholder="">
			</div>
			<p>icon图标参考<mark><a href="http://www.layui.com/v1/doc/element/icon.html">layui</a></mark></p>
		</div>
		<input type="hidden" name="id" value="<?php echo e($rule->id); ?>">
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit type="button" lay-filter="editRule">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("js"); ?>
	<script type="text/javascript" src="<?php echo e(asset('/xianshangke/modul/rule/editRule.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.layout.modify", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/rule/editRule.blade.php ENDPATH**/ ?>