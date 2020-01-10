<?php

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('login', 'LoginController@index');
    Route::post('login', 'LoginController@signIn')->name('admin.login');
    Route::get('logout', 'LoginController@logout');


    Route::group(['middleware' => 'auth:admin,web'], function () {
        Route::get('/', 'IndexController@index');
        Route::get('index', 'IndexController@index');
        Route::get('home', 'IndexController@home');// 加载页面
        Route::get('menu', 'IndexController@getMenu');
        Route::get('forbidden', 'IndexController@forbidden');
        Route::get('main', 'IndexController@main');

        Route::group(['middleware' => 'rbac'], function () {
            Route::get('user/password/edit', 'IndexController@editPassword');
            Route::put('user/password', 'IndexController@editPassword');
            // 管理员管理
            Route::get('usersList', 'RuleController@adminsPage');
            Route::get('users', 'RuleController@getAdmins');
            Route::get('user/create', 'RuleController@addAdmin');
            Route::post('user', 'RuleController@addAdmin');
            Route::get('user/{id}/edit', 'RuleController@editAdmin');
            Route::put('user', 'RuleController@editAdmin');
            Route::patch('user', 'RuleController@activeAdmin');
            Route::delete('user', 'RuleController@delAdmin');
            // 权限管理
            Route::get('rules', 'RuleController@rules');
            Route::get('rule/create', 'RuleController@addRule');
            Route::post('rule', 'RuleController@addRule');
            Route::get('rule/{id}/edit', 'RuleController@editRule');
            Route::put('rule', 'RuleController@editRule');
            Route::delete('rule', 'RuleController@deleteRule');
            Route::patch('rule', 'RuleController@editRuleStatus');
            // 角色管理
            Route::get('role/create', 'RuleController@addRole');
            Route::post('role', 'RuleController@addRole');
            Route::get('role/{id}/edit', 'RuleController@editRole');
            Route::put('role', 'RuleController@editRole');
            Route::delete('role', 'RuleController@deleteRole');
            Route::get('roles', 'RuleController@roles');
            // 权限配置
            Route::get('role/{role_id}/rules', 'RuleController@setRules');
            Route::put('role/{role_id}/rules', 'RuleController@storeRules');

            //基本配置
            Route::resource('config', 'ConfigController');
            Route::post('config/list','ConfigController@list');

            //会员
            Route::resource('member', 'MemberController');
            Route::post('member/list','MemberController@list');

            //失信
            Route::resource('breach', 'BreachController');
            Route::post('breach/list','BreachController@list');


            //合同模板
            Route::resource('template', 'TemplateController');
            Route::post('template/list','TemplateController@list');

            //实名认证
            Route::resource('certification', 'CertificationController');
            Route::post('certification/list','CertificationController@list');

            //通知
            Route::resource('notice', 'NoticeController');
            Route::post('notice/list','NoticeController@list');
        });
    });

});