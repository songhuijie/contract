<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CreateRule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:rule {name} {d} {id}';

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
        //路由名 跟quick 一样 template
        //示例  php artisan create:rule template 模板
        //  然后在 加上 对应的路由和对应的控制器 更改model 和controller 即可
        //            Route::resource('template', 'TemplateController');
        //            Route::post('template/list','TemplateController@list');

        $name = $this->argument('name');
        $describe = $this->argument('d');
        $id = $this->argument('id');
//
        $controller = $name.'controller';
        $data = [
            ['title' => $describe."列表数据", 'href' => "/admin/$name/list", 'rule' => "$controller@list", 'pid' => $id, 'check' => 1, 'status' => 1, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => "添加".$describe, 'href' => "/admin/$name/create", 'rule' => "$controller@create", 'pid' => $id, 'check' => 1, 'status' => 1, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => $describe.'保存', 'href' => "/admin/$name", 'rule' => "$controller@store", 'pid' => $id, 'check' => 1, 'status' => 1, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '修改'.$describe, 'href' => "/admin/$name/{id}/edit", 'rule' => "$controller@edit", 'pid' => $id, 'check' => 1, 'status' => 1, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => $describe.'更新', 'href' => "/admin/$name/{id}", 'rule' => "$controller@update", 'pid' => $id, 'check' => 1, 'status' => 1, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => $describe.'删除', 'href' => "/admin/$name/{id}", 'rule' => "$controller@destroy", 'pid' => $id,'check' => 1, 'status' => 1, 'level' => 3, 'icon' => '', 'sort' => 0],


        ];
        DB::table('rules')->insert($data);


        Artisan::call("quick $name --d=$describe");
    }
}
