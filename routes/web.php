<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require 'admin.php';

Route::get('/', function () {
    return redirect('/admin/index');
});

//文件上传
Route::any('/file/img','File\FileController@img');
Route::any('layer/upload','File\FileController@LayerUpload');

Route::get('/test','TestController@test');