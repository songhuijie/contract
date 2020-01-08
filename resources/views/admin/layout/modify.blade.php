<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>
    <link href="{{asset('assets/libs/layui/css/layui.css')}}" rel="stylesheet">
    {{--<link href="{{asset('page/table/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">--}}
    <link href="{{asset('page/table/vendor/metisMenu/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{asset('page/table/vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('page/table/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
    <link href="{{asset('page/table/dist/css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="{{asset('page/table/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">


    @yield('css')
    <script src="{{asset('page/table/vendor/jquery/jquery.min.js')}}"></script>
<!-- <script src="{{asset('assets/libs/layui/lay/modules/jquery.js')}}"></script> -->
    {{--<script src="{{asset('page/table/vendor/bootstrap/js/bootstrap.min.js')}}"></script>--}}
    <script src="{{asset('page/table/vendor/metisMenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('page/table/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('page/table/vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('page/table/vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{asset('page/table/dist/js/sb-admin-2.js')}}"></script>


    {{--<script src="{{asset('assets/libs/layui/layui.all.js')}}"></script>--}}
 <script src="{{asset('assets/libs/layui/layui.js')}}"></script>

    @yield('js')
    <style>
        .page-header{
            border-bottom: none !important;
        }
        #page-wrapper{
            border-left: none !important;
        }
        /*.layui-form input[type=checkbox], .layui-form input[type=radio], .layui-form select{*/
            /*display: block;*/
            /*appearance: none;*/
            /*-moz-appearance: none;*/
            /*-webkit-appearance: none;*/
            /*color: #337ab7;*/
            /*width: 100%;*/
            /*border-color: #e6e6e6;*/
            /*height: 38px;*/
        /*}*/
    </style>
</head>

<body>
@yield('content')



</body>

</html>

