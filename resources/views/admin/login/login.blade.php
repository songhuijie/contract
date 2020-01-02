<!-- 继承 -->
@extends('admin.layout.login')

<!-- 加载内容 -->
@section('content')
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
@endsection
