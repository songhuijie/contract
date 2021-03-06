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

        //获取合同代写支付金额 (后台配置)
        $api->post('/get/config','OtherController@getConfig');

        $api->post('/login','UserController@login');
        $api->any('/notify','ContractController@notify');
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



            //用户认证
            $api->post('/certification/user','AuthenticationController@UserCertification');
            //用户认证
            $api->post('/send/verification/code','AuthenticationController@SendVerificationCode');


            //模板
            $api->post('/contract/template','ContractController@template');
            //模板
            $api->post('/template/content','ContractController@templateContent');
            //获取所有用户
            $api->post('/contract/distribute/user','ContractController@userList');



            /**
             * 需要实名认证才能使用
             */
            $api->group(['middleware'=>'CheckAuthentication'],function($api){
                //创建印章
                $api->post('/seal/create','AuthenticationController@CreateSeal');
                $api->post('/get/user','ContractController@getUser');

                //获取合同详细信息 或者修改
                $api->post('/contract/detail','ContractController@getContractDetail');
                //获取合同信息根据条件
                $api->post('/contract/list','ContractController@getContract');
                //支付律师代写合同
                $api->post('/contract/pay','ContractController@PayOrder');

                /**
                 * 需要印章才能请求
                 */
                $api->group(['middleware'=>'CheckSeal'],function($api){
                    //合同
                    //获取印章
                    $api->post('/seal/get','AuthenticationController@getSeal');
                    //创建合同
                    $api->post('/contract/creation','ContractController@ContractCreation');



                    //签署合同
                    $api->post('/contract/sign','ContractController@sign');
                    //律师代写完后等待确认合同
                    $api->post('/contract/confirm','ContractController@Confirm');

                });
            });
        });

    });


});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});