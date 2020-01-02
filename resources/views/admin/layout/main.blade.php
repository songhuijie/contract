<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>线上客客户服务器控制台</title>
    <link rel="stylesheet" href="<?php echo asset('/xianshangke/css/layout.css')?>">
    <link rel="stylesheet" href="<?php echo asset('/xianshangke/css/home.css')?>">
</head>
<body>
<div class="layout">
    <div class="left">
        <h1>控制台</h1>
        <ul class="list">
        </ul>
        <p>线上客技术支持</p>
    </div>
    <div class="right">
        <div class="head">
            <ul >
                <li>帮助中心</li>
                <li>修改密码</li>
                <li><a href="/admin/logout">退出系统</a></li>
            </ul>
        </div>
        <div class="main">
            <div class="left_two">
            </div>
            <div class="content"  id="pjax-container">
            {{--<div class="content" id="home">--}}
                @yield('content')
            </div>


        </div>
    </div>
</div>
<script src="<?php echo asset('/xianshangke/js/jquery-3.4.1.min.js')?>"></script>
<script src="<?php echo asset('/xianshangke/js/home.js?v=2')?>"></script>
</body>
</html>