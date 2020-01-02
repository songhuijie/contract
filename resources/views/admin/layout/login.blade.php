<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>线上客客户服务器控制台</title>
    <link rel="stylesheet" href="<?php echo asset('/xianshangke/css/login.css')?>">
</head>
<body>
@yield('content')
<script src="<?php echo asset('/xianshangke/js/jquery-3.4.1.min.js')?>"></script>
<script src="<?php echo asset('/xianshangke/layui/layui.js')?>"></script>
<script src="<?php echo asset('/xianshangke/js/login.js?v=2')?>"></script>


</body>
</html>