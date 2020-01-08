<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['prefix' => 'v1', 'Middleware' => 'CheckMiddle', 'namespace' => 'App\Http\Controllers\Api'], function ($api) {
        $api->post('/login','UserController@login');

        // 登陆后 查看接口
        $api->group(['middleware'=>'CheckAccessToken'],function($api){
            //用户信息
            $api->post('/user_info','UserController@userInfo');


            //失信人查询
            $api->post('/breach/query','BreachController@query');
            //失信人查询
            $api->post('/breach/detail','BreachController@detail');


            //搜索历史
            $api->post('/breach/history','BreachController@history');


        });

    });


});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});