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



            //关于我们
            $api->post('/about','OtherController@aboutUs');
            //通知信息
            $api->post('/notice/list','OtherController@notice');
            //查看通知
            $api->post('/notice/check','OtherController@check');

            //合同
            //模板
            $api->post('/contract/template','ContractController@template');
            //创建合同
            $api->post('/contract/creation','ContractController@ContractCreation');
            //获取合同信息根据条件
            $api->post('/contract/list','ContractController@getContract');
            //获取所有用户
            $api->post('/contract/distribute/user','ContractController@userList');


            //用户认证
            $api->post('/certification/user','AuthenticationController@UserCertification');
            //获取印章
            $api->post('/seal/get','AuthenticationController@getSeal');
            //创建印章
            $api->post('/seal/create','AuthenticationController@CreateSeal');





        });

    });


});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});