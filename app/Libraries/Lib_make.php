<?php
/**
 * Created by PhpStorm.
 * User: shj
 * Date: 2018/10/10
 * Time: 上午11:21
 */
namespace App\Libraries;

use App\Models\Config;
use Illuminate\Support\Facades\Redis;

class Lib_make{

    public static function getConfig(){

        $config = Redis::get(Lib_redis::SplicingKey(Lib_redis::CONFIG));

        if($config){
            return json_decode($config,true);
        }else{
            $config_model = new Config();
            $config_all = $config_model->all();

            $config = [];
            foreach($config_all as $k=>$v){
                $config[$v->key] = $v->value;
            }
            Redis::setex(Lib_redis::SplicingKey(Lib_redis::CONFIG),78200,json_encode($config));
            return $config;
        }
    }



}