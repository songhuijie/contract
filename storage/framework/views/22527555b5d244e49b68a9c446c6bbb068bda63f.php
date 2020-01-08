<!-- 加载内容 -->
<?php $__env->startSection('content'); ?>
    <style>
        .content>div{
            display: flex !important
        }
    </style>
<div style="">
    <div class="show">
        <img src="<?php echo asset("xianshangke/img/1-1.png") ?>" alt="">
        <b>0</b>
        <span>今日新增会员</span>
    </div>
    <div class="show">
        <img src="<?php echo asset("xianshangke/img/dd.png") ?>" alt="">
        <b>0</b>
        <span>今日付款订单</span>
    </div>
    <div class="show">
        <img src="<?php echo asset("xianshangke/img/fkje.png") ?>" alt="">
        <b><i>$</i> 0.00</b>
        <span>今日付款金额</span>
    </div>
    <div class="show">
        <img src="<?php echo asset("xianshangke/img/tztix.png") ?>" alt="">
        <b><i>$</i> 0.00</b>
        <span>团长提现中金额</span>
    </div>
    <div class="show">
        <img src="<?php echo asset("xianshangke/img/tzyj.png") ?>" alt="">
        <b><i>$</i> 0.00</b>
        <span>团长总佣金</span>
    </div>
    <div class="show">
        <img src="<?php echo asset("xianshangke/img/ddje.png") ?>" alt="">
        <b><i>$</i> 0</b>
        <span>订单金额</span>
    </div>
</div>
<div>
    <div class="item">
        <h6>待处理事务</h6>
        <div>
            <p>商品库存报警<span>4</span></p>
            <p>待付款订单<span>0</span></p>
            <p>备货中订单<span>0</span></p>
            <p>待处理退款<span>0</span></p>
            <p>待评价订单<span>0</span></p>
            <p>待审核评价<span>0</span></p>
            <p>仓库中商品<span>0</span></p>
            <p>待处理退货<span>0</span></p>
            <p>团长提现<span>0</span></p>
        </div>
    </div>
    <div class="item">
        <h6>交易统计</h6>
    </div>
</div>
<div>
    <div class="item">
        <h6>商城信息统计</h6>
        <div>
            <div>
                <p><strong>18</strong></p>
                <p>会员天数</p>
            </div>
            <div>
                <p><strong>5</strong></p>
                <p>商品总数</p>
            </div>
            <div>
                <p><strong>4</strong></p>
                <p>团长总数</p>
            </div>
            <div>
                <p><strong>0</strong></p>
                <p>近七天订单数</p>
            </div>
            <div>
                <p><strong>0.00</strong></p>
                <p>近七天销售额(元)</p>
            </div>
            <div>
                <p><strong>0.00</strong></p>
                <p>近七天退款金额(元)</p>
            </div>
        </div>
    </div>
    <div class="item quick">
        <h6>快捷入口</h6>
        <div>
            <div>
                <p><img src="<?php echo asset("xianshangke/img/4-1.png") ?>" alt=""></p>
                <p>发布商品</p>
            </div>
            <div>
                <p><img src="<?php echo asset("xianshangke/img/4-2.png") ?>" alt=""></p>
                <p>订单列表</p>
            </div>
            <div>
                <p><img src="<?php echo asset("xianshangke/img/4-3.png") ?>" alt=""></p>
                <p>会员管理</p>
            </div>
            <div>
                <p><img src="<?php echo asset("xianshangke/img/4-4.png") ?>" alt=""></p>
                <p>团长管理</p>
            </div>
            <div>
                <p><img src="<?php echo asset("xianshangke/img/4-5.png") ?>" alt=""></p>
                <p>供应商管理</p>
            </div>
            <div>
                <p><img src="<?php echo asset("xianshangke/img/4-6.png") ?>" alt=""></p>
                <p>提现申请</p>
            </div>
            <div>
                <p><img src="<?php echo asset("xianshangke/img/4-7.png") ?>" alt=""></p>
                <p>提现设置</p>
            </div>
            <div>
                <p><img src="<?php echo asset("xianshangke/img/4-8.png") ?>" alt=""></p>
                <p>幻灯片设置</p>
            </div>
            <div>
                <p><img src="<?php echo asset("xianshangke/img/4-9.png") ?>" alt=""></p>
                <p>售后处理</p>
            </div>
            <div>
                <p><img src="<?php echo asset("xianshangke/img/4-10.png") ?>" alt=""></p>
                <p>站点设置</p>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/index/index.blade.php ENDPATH**/ ?>