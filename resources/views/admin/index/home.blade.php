@extends('admin.layout.main')

<!-- 加载内容 -->
@section('content')
    <div>
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
@endsection