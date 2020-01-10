<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/8
 * Time: 9:47
 */
namespace App\Libraries;
class Lib_redis{


    const CONFIG = ':config';
    const USER_LIST = ':user:list';
    const SEARCH_HISTORY = ':search:history';


    public static function SplicingKey($key){
        return env('redis_key_prefix','contract').$key;
    }

}