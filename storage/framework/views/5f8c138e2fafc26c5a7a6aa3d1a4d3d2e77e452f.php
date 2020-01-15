<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <link rel="stylesheet" href="<?php echo e(asset('/xianshangke/extra/treegrid/css/jquery.treegrid.css')); ?>" media="all" />
	<blockquote class="layui-elem news_search">
		<div class="layui-inline">
			<a class="layui-btn ruleAdd_btn" style="background-color:#5FB878">添加权限</a>
		</div>
		<div class="layui-inline">
			<div class="layui-form-mid layui-word-aux">&nbsp;&nbsp;&nbsp;&nbsp;权限更改后,需要所有后台用户重新登录才会立即生效</div>
		</div>
	</blockquote>
	<div class="layui-form links_list">
	  	<table class="layui-table tree">
		    <colgroup>
				<col width="100px">
				<col width="">
				<col>
				<col>
				<col width="20px">
				<col width="20px">
				<col width="7%">
				<col width="">
		    </colgroup>
		    <thead>
				<tr>
					<th>#</th>
					<th style="text-align:left;">权限名称</th>
					<th style="text-align:left;">链接</th>
					<th style="text-align:left;">控制器@方法</th>
					<th>是否验证权限</th>
					<th>是否显示</th>
					<th>排序</th>
					<th>操作</th>
				</tr> 
		    </thead>
		    <tbody class="links_content">
			<?php $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class="treegrid-<?php echo e($rule['id']); ?> <?php if($rule['pid']!=0): ?> treegrid-parent-<?php echo e($rule['pid']); ?> <?php endif; ?>">
					<td><?php echo e($rule['id']); ?></td>
					<td style="text-align:left;"><?php echo e($rule['ltitle']); ?></td>
					<td style="text-align:left;"><?php echo e($rule['href']); ?></td>
					<td style="text-align:left;"><?php echo e($rule['rule']); ?></td>
					<td>
						<input data-id="<?php echo e($rule['id']); ?>" type="checkbox" lay-skin="switch" lay-text="是|否" lay-filter="isCheck"
							   <?php if($rule['check'] == 1): ?> checked <?php endif; ?>>
					</td>
					<td>
						<input data-id="<?php echo e($rule['id']); ?>" type="checkbox" lay-skin="switch" lay-text="是|否" lay-filter="isShow"
							   <?php if($rule['status'] == 1): ?> checked <?php endif; ?>>
					</td>
					<td>
						<input data-id="<?php echo e($rule['id']); ?>" type="text" class="layui-input sort_input"  value="<?php echo e($rule['sort']); ?>">
					</td>
					<td>
						<a data-id="<?php echo e($rule['id']); ?>" class="layui-btn layui-btn-xs rule_edit">
							<i class="layui-icon">&#xe642;</i>
							编辑
						</a>
						<a data-id="<?php echo e($rule['id']); ?>" class="layui-btn layui-btn-danger layui-btn-xs rule_del">
							<i class="layui-icon"></i>
							删除
						</a>
					</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
		</table>
	</div>


    <script type="text/javascript" src="<?php echo e(asset('/xianshangke/extra/treegrid/js/jquery.treegrid.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/xianshangke/modul/rule/rules.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("js"); ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make("admin.layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/rule/rules.blade.php ENDPATH**/ ?>