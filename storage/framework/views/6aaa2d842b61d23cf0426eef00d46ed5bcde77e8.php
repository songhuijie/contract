<?php $__env->startSection("content"); ?>
    <blockquote class="layui-elem news_search">
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" value="" placeholder="账户名" class="layui-input search_input">
            </div>
            <a class="layui-btn search_btn">查询</a>
        </div>
        <div class="layui-inline">
            <a class="layui-btn layui-btn-normal add_btn">添加管理员</a>
        </div>
        <div class="layui-inline">
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
    </blockquote>
    <table id="users" lay-filter="usertab"></table>

    <script type="text/html" id="active">
        {{# if(d.status == 1){ }}
        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="active">已开启</a>
        {{#  } else { }}
        <a class="layui-btn layui-btn-normal layui-btn-danger layui-btn-xs" lay-event="active">已禁用</a>
        {{# } }}
    </script>
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
    <script type="text/javascript" src="<?php echo e('/xianshangke/modul/rule/user.js'); ?>"></script>
<?php $__env->stopSection(); ?>






<?php echo $__env->make("admin.layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/rule/users.blade.php ENDPATH**/ ?>