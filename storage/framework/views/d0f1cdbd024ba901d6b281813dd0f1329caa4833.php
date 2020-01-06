<?php $__env->startSection("content"); ?>
	<form class="layui-form layui-form-pane" style="width:80%;">
		<div class="layui-form-item">
			<label class="layui-form-label">父级</label>
			<div class="layui-input-block">
				<select name="pid">
					<option value="0">默认顶级</option>
					<?php $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option data-level="<?php echo e($rule['level']); ?>" value="<?php echo e($rule['id']); ?>"><?php echo e($rule['ltitle']); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</select>
			</div>
		</div>


		<div class="layui-form-item">
			<label class="layui-form-label">权限名称</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="title" lay-verify="required" placeholder="请输入权限名称">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">链接</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="href" placeholder="/rules">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">控制器@方法</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="rule" placeholder="RuleController@rules">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">图标</label>
			<div class="layui-input-inline">
				<input type="text" class="layui-input" name="icon" placeholder="">
			</div>
			<p>icon图标参考<mark><a href="http://www.layui.com/doc/element/icon.html">layui</a></mark></p>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" type="button" lay-submit lay-filter="addRule">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
	<script type="text/javascript" src="<?php echo e(asset('/xianshangke/modul/rule/addRule.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("js"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.layout.modify", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\xianshangke\resources\views/admin/rule/addRule.blade.php ENDPATH**/ ?>