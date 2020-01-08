<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/8
 * Time: 10:03
 */

namespace App\Http\Controllers;

use App\Libraries\Lib_make;

class TestController extends Controller{


    public function test(){
        $config = Lib_make::getConfig();

        dd($config);
    }
}