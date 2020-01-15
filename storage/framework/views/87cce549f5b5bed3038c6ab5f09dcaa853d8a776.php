<?php $__env->startSection("content"); ?>
    <div class="layui-container">
        <?php if($Information): ?>
            <h2>身份证正面信息</h2>
            <br/>
            <div class="layui-row">
                <div class="layui-col-md1">
                    地址:
                </div>
                <div class="layui-col-md9">
                    <?php echo e(isset($Information->identity_card_positive['address'])?$Information->identity_card_positive['address']:''); ?>

                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-md1">
                    生日:
                </div>
                <div class="layui-col-md9">
                    <?php echo e(isset($Information->identity_card_positive['birth'])?$Information->identity_card_positive['birth']:''); ?>

                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-md1">
                    姓名:
                </div>
                <div class="layui-col-md9">
                    <?php echo e(isset($Information->identity_card_positive['name'])?$Information->identity_card_positive['name']:''); ?>

                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-md1">
                    民族:
                </div>
                <div class="layui-col-md9">
                    <?php echo e(isset($Information->identity_card_positive['nationality'])?$Information->identity_card_positive['nationality']:''); ?>

                </div>
            </div>

            <div class="layui-row">
                <div class="layui-col-md1">
                    身份证号:
                </div>
                <div class="layui-col-md9">
                    <?php echo e(isset($Information->identity_card_positive['num'])?$Information->identity_card_positive['num']:''); ?>

                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-md1">
                    性别:
                </div>
                <div class="layui-col-md9">
                    <?php echo e(isset($Information->identity_card_positive['sex'])?$Information->identity_card_positive['sex']:''); ?>

                </div>
            </div>

            <br/>
            <h2>背面信息</h2>
            <br/>

            <div class="layui-row">
                <div class="layui-col-md3">
                    有效期起始时间-有效期结束时间:
                </div>
                <div class="layui-col-md9">
                    <?php echo e(isset($Information->identity_card_back['start_date'])?$Information->identity_card_back['start_date']:''); ?>-<?php echo e(isset($Information->identity_card_back['end_date'])?$Information->identity_card_back['end_date']:''); ?>

                </div>
            </div>

            <div class="layui-row">
                <div class="layui-col-md1">
                    签发机关:
                </div>
                <div class="layui-col-md9">
                    <?php echo e(isset($Information->identity_card_back['issue'])?$Information->identity_card_back['issue']:''); ?>

                </div>
            </div>
        <?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.layout.modify", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/certification/info.blade.php ENDPATH**/ ?>