<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class QuickGeneration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quick {directory_name} {--d=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        //目录名

        $directory = $this->argument('directory_name');
        $describe = $this->option('d');
        if(!$describe){
            $describe = '';
        }

        $str = preg_replace_callback("/_+([a-z])/",function($matches){
            print_r($matches); //Array ( [0] => _b [1] => b )
            return strtoupper($matches[1]);
        },$directory);

        $sentence = ucfirst($str);



        try{

            //生成模型
            $this->GenerationModel($sentence);
            //生成控制器
            $this->GenerationController($sentence);

            //生成视图
            $this->GenerationView($directory,$sentence,$describe);

            //生成JS文件
            $this->GenerationJs($directory,$describe);

            dd('success');
        }catch (\Exception $e){
            return '模型 控制器 已存在';
        }

    }

    public function GenerationModel($sentence){

        exec("php artisan make:model Models\\$sentence");

    }

    public function GenerationController($sentence){
        $controller = $sentence.'Controller';
        exec("php artisan make:controller Admin\\$controller --model=App\\Models\\$sentence");
    }

    public function GenerationView($directory,$sentence,$describe){
        //生成index页面
        $now_directory = resource_path()."/views/admin/".$directory.'/';
        $file_name = $now_directory."index.blade.php";
        if(!is_dir($now_directory)){
            mkdir($now_directory,0777);
        }
        $data = <<<EOT
        @extends("admin.layout.main")

@section("content")
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
    <table id="{$directory}" lay-filter="usertab"></table>

    
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
    <script type="text/javascript" src="{{'/xianshangke/modul/rule/{$directory}.js'}}"></script>
@endsection
EOT;



        file_put_contents($file_name,$data);
        if(!is_file($file_name)){
            touch($file_name,0777);
        }



        //生成添加 修改页面
        $file_add_name = $now_directory."add$sentence.blade.php";


        $config = [
            'config'=>'$config',
            'key'=>'$config->key',
            'describe'=>'$config->describe',
            'value'=>'$config->value',
            'id'=>'$config->id',
        ];
        $add_data = <<<EOT
        @extends("admin.layout.modify")

@section("content")
    <div id="wrapper" style="margin-top:20px;">
        <div id="page-wrapper">
            <form class="layui-form" >

                <div class="layui-form-item">
                    <label class="layui-form-label">配置key</label>
                    <div class="layui-input-block">
                        <input type="text" name="key" required  lay-verify="required"  placeholder="请输入配置key" autocomplete="off" class="layui-input" value="@if(!empty({$config['config']})){{{$config['key']}}}@endif">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">描述</label>
                    <div class="layui-input-block">
                        <input type="text" name="describe" required  lay-verify="required"  placeholder="请输入key描述(作用)" autocomplete="off" class="layui-input" value="@if(!empty({$config['config']})){{{$config['describe']}}}@endif">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">值</label>
                    <div class="layui-input-block">
                        <input type="text" name="value" required  lay-verify="required"  placeholder="请输入配置key的值" autocomplete="off" class="layui-input" value="@if(!empty({$config['config']})){{{$config['value']}}}@endif">
                    </div>
                </div>

                @if(!empty({$config['config']}))
                    <input type="text" id="mold" hidden  value="edit" >
                    <input type="text" id="id" hidden value="{{{$config['id']}}}" >
                @endif

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit="" lay-filter="formDemo">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>


        </div>


    </div>
    
     <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        layui.use(['util','form','laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element', 'slider'], function(){
            var laydate = layui.laydate //日期
                ,laypage = layui.laypage //分页
                ,layer = layui.layer //弹层
                ,table = layui.table //表格
                ,carousel = layui.carousel //轮播
                ,upload = layui.upload //上传
                ,element = layui.element //元素操作
                ,slider = layui.slider //滑块
            var form = layui.form;
//执行实例 多图上传
            upload.render({
                elem: '#test2'
                ,method: 'post'
                ,multiple: true //是否允许多文件上传。设置 true即可开启。不支持ie8/9
                ,url: '{{URL("file/img")}}' //上传接口
                ,done: function(index, upload){
                    //获取当前触发上传的元素，一般用于 elem 绑定 class 的情况，注意：此乃 layui 2.1.0 新增
                    if(index.code!=0){
                        layer.msg("上传错误",{icon:5});
                    }else{
                        layer.msg("上传成功",{icon:6});
                        img="../"+index.data;
                        $("#img2").append('<img src="'+img+'" name="img[]" width="20%"><input type="text" value="'+index.data+'" hidden name="rotation[]">')
                    }
                }
            });
            //监听提交
            form.on('submit(formDemo)', function(data){

                var date=data.field;

                if(date.key==""||date.describe==""||date.value==""){
                    layer.msg("不能为空,请填写完整",{icon:5});return false;
                }

                if($("#mold").val()!=undefined){
                    // date.id=$("#id").val();

                    url = "/admin/$directory/"+$("#id").val();

                    $.ajax({
                        data:date,
                        type: 'put',
                        datatype:"json",
                        url:url,
                        success:function(res){
                            console.log(res);
                            if(res.code==0){
                                parent.layer.msg(res.msg);
                                setTimeout(function(){
                                    parent.layer.closeAll();
                                    parent.location.reload();
                                },1000)
                            }else{
                                parent.layer.msg(res.msg);
                            }

                        }
                    });
                }else{
                    $.ajax({
                        data:date,
                        type:"post",
                        datatype:"json",
                        url:"{{url('admin/$directory')}}",
                        success:function(res){
                            console.log(res);
                            if(res.code==0){
                                parent.layer.msg(res.msg);
                                setTimeout(function(){
                                    parent.layer.closeAll();
                                    parent.location.reload();
                                },1000)
                            }else{
                                parent.layer.msg(res.msg);
                            }

                        }
                    });
                }

                return false;
            });
            //底部信息
            // var footerTpl = lay('#footer')[0].innerHTML;
            // lay('#footer').html(layui.laytpl(footerTpl).render({}))
            // .removeClass('layui-hide');
        });
    </script>
@endsection

EOT;
        file_put_contents($file_add_name,$add_data);
        if(!is_file($file_add_name)){
            touch($file_add_name,0777);
        }



    }

    public function GenerationJs($directory,$describe){
       $now_directory =  public_path()."/xianshangke/modul/rule/";

       $js_data = <<<EOT
        layui.config({base: '/xianshangke/modul/common/'}).use(['table', 'dialog', 'his'], function(){
    var table = layui.table
        ,dialog = layui.dialog
        ,his = layui.his
        ,$ = layui.$;

    table.render({
        elem: '#$directory'
        ,url: '/admin/$directory/list' //数据接口
        ,method: 'post'
        ,page: true //开启分页
        ,limit: 10
        ,limits: [10, 20]
        ,cols: [[ //表头
            {field: 'id', title: 'ID', sort: true, fixed: 'left', align: 'left'}
            ,{field: 'key', title: '配置Key名'}
            ,{field: 'describe', title: '描述'}
            ,{field: 'value', title: '配置key 值'}
            ,{title: '操作', toolbar: '#op'}
        ]]
        ,response: {
            statusName: 'code'
            ,statusCode: 0
            ,msgName: 'msg'
            ,countName: 'meta'
            ,dataName: 'data'
        }
//				,skin: 'row' // 'line', 'row', 'nob'
        ,even: false //开启隔行背景
//                ,size: 'lg' // 'sm', 'lg'

    });

    table.on('tool(usertab)', function(obj){
        var data = obj.data;      //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr;          //获得当前行 tr 的DOM对象

        if (layEvent == 'active') {
            
        } else if (layEvent == 'edit') {
            var url = '/admin/$directory/'+data.id+'/edit';
            layer.open({
                title:"编辑$describe",
                type: 2,
                area: ['80%', '80%'],
                content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
            });

        } else if (layEvent == 'del') {
            dialog.confirm('确认删除改{$describe}么', function () {
                var loadIndex = dialog.load('删除中，请稍候');
                his.ajax({
                    url: '/admin/$directory/'+data.id
                    ,type: 'delete'
                    ,complete: function () {
                        dialog.close(loadIndex);
                    }
                    ,error: function (msg) {
                        dialog.error(msg);
                    }
                    ,success: function () {
                        dialog.msg('删除成功');
                        obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                    }
                });
            })

        }

    });

    function flushTable (cond, sortObj) {
        var query = {
            where: {
                cond: cond
            }
            ,page: {
                curr: 1
            }
        };
        if (sortObj != null) {
            query.initSort = sortObj;
            query.where.sortField = sortObj.field;   // 排序字段
            query.where.order = sortObj.type;        //排序方式
        }
        table.reload('$directory', query);
    }

    // 搜索
    $('.search_btn').click(function () {
        var cond = $('.search_input').val();
        flushTable(cond);
    });

    // 排序
    table.on('sort(usertab)', function (obj) {
        var cond = $('.search_input').val();
        flushTable(cond, obj);
    });

    $('.add_btn').click(function () {

        var url = '/admin/$directory/create';
        layer.open({
            title:"添加$describe",
            type: 2,
            area: ['80%', '80%'],
            content: url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        });
    });

});
EOT;
       $file_js_name = $now_directory."$directory.js";

        file_put_contents($file_js_name,$js_data);
        if(!is_file($file_js_name)){
            touch($file_js_name,0777);
        }
    }
}
