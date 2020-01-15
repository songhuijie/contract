<?php $__env->startSection("content"); ?>
    <div id="wrapper" style="margin-top:20px;">
        <div id="page-wrapper">
            <form class="layui-form" >

                <div class="layui-form-item">
                    <label class="layui-form-label">审核</label>
                    <div class="layui-input-block">
                        <input type="radio" name="status" value="1" title="通过" checked>
                        <input type="radio" name="status" value="2" title="拒绝" >
                    </div>
                </div>



                <?php if(!empty($certification)): ?>
                    <input type="text" id="mold" hidden  value="edit" >
                    <input type="text" id="id" hidden value="<?php echo e($certification->user_id); ?>" >
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.layout.modify", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/certification/info.blade.php ENDPATH**/ ?>