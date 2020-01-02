<!-- 继承 -->


<!-- 加载内容 -->
<?php $__env->startSection('content'); ?>
    <form  action="" id="form">
        <h2>线上客客户服务器控制台</h2>
        <input type="text" name="username" id="username">
        <input type="password" name="password" id="pwd">
        <div>
            <input type="checkbox" name="remember"><span>记住用户密码</span>
        </div>
        <button  id="loginbtn">登 &nbsp;录</button>
    </form>
    <p>四川线上客信息技术开发有限公司提供技术支持</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy\WWW\html\xianshangke\xianshangke\resources\views/admin/login/login.blade.php ENDPATH**/ ?>