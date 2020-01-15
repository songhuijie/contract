<?php $__env->startSection("content"); ?>
    <div class="layui-container">
        常规布局（以中型屏幕桌面为例）：
        <div class="layui-row">
            <div class="layui-col-md9">
                你的内容 9/12
            </div>
            <div class="layui-col-md3">
                你的内容 3/12
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.layout.modify", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/certification/info.blade.php ENDPATH**/ ?>