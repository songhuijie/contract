        

<?php $__env->startSection("content"); ?>
    <blockquote class="layui-elem news_search">
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" value="" placeholder="" class="layui-input search_input">
            </div>

            <div class="layui-inline">
                <select name="contract_type" id="contract_type" lay-verify="">
                        <option value="1" selected>系统模板</option>
                        <option value="2">律师代写</option>
                </select>
            </div>
            <a class="layui-btn search_btn">查询</a>

        </div>
        <div class="layui-inline">
            <a class="layui-btn layui-btn-normal add_btn">添加</a>
        </div>
        <div class="layui-inline">
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
    </blockquote>
    <table id="contract" lay-filter="usertab"></table>

    
    <script type="text/html" id="op">

        
        {{#  if(d.contract_type == 2 && d.status == 1){ }}
        <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>编辑</a>
        {{#  } }}

        

        
            
            
        
    </script>
    <script type="text/javascript" src="<?php echo e('/xianshangke/modul/rule/contract.js'); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("admin.layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/contract/index.blade.php ENDPATH**/ ?>