<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class QuickGeneration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quick:generation {directory_name}';

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
            $this->GenerationView($directory);


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

    public function GenerationView($directory){
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
    <table id="users" lay-filter="usertab"></table>

    
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
    }
}
