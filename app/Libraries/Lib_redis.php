<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/8
 * Time: 9:47
 */
namespace App\Libraries;
use Illuminate\Support\Facades\Redis;

class Lib_redis{


    const CONFIG = ':config';
    const TEMPLATE = ':template';
    const USER_LIST = ':user:list';
    const SEARCH_HISTORY = ':search:history';


    public static function SplicingKey($key){
        return env('redis_key_prefix','contract').$key;
    }


    /**
     * 手机号验证
     */
    public static function vilidatoerSms($code){


    }
}