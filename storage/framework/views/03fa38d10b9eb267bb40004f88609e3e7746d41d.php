        

<?php $__env->startSection("content"); ?>
    <blockquote class="layui-elem news_search">
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" value="" placeholder="" class="layui-input search_input">
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
    <table id="certification" lay-filter="usertab"></table>

    
    <script type="text/html" id="op">
        <a class="layui-btn layui-btn-xs edit_user" lay-event="edit">
            <i class="layui-icon">&#xe642;</i>
            编辑
        </a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">
            <i class="layui-icon"></i>
            删除
        </a>
    </script>

    <script type="text/html" id="identity_card_positive">
        
        <img src="{{d.identity_card_positive}}">
        
    </script>

    <script type="text/html" id="identity_card_back">
        
        <img src="{{d.identity_card_back}}">
        
    </script>

    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="view">查看详情</a>
        
        {{#  if(d.status !=1){ }}
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        {{#  } }}

        

        
    </script>
    <script type="text/javascript" src="<?php echo e('/xianshangke/modul/rule/certification.js'); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("admin.layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/certification/index.blade.php ENDPATH**/ ?>