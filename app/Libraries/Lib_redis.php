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
    const VERIFICATION_CODE = ':verification:code:';
    const TIME_ERROR = ':time:error:';
    const LIMITED_TIME = ':limited:time:';
    const SEARCH_HISTORY = ':search:history';


    //发送验证码 限制1分钟（可能不会有1分钟加请求返回时间 设定50秒）
    const LIMIT_TIME = 50;
    //验证码存活时间10分钟
    const VERIFICATION_CODE_TIME = 600;
    //验证码最大尝试次数
    const MAXIMUM_ATTEMPTS = 3;

    public static function SplicingKey($key){
        return env('redis_key_prefix','contract').$key;
    }


    /**
     * 存储验证码到redis 发送验证码
     * @param $phone
     * @param $code
     * @return int
     */
    public static function sendVerificationCode($phone,$code){

        $limited_key = self::SplicingKey(self::LIMITED_TIME.$phone);
        $phone_code_key = self::SplicingKey(self::VERIFICATION_CODE.$phone);
        if(Redis::ttl($limited_key) > 0){
            return Lib_const_status::FREQUENT_SENDING_OF_VERIFICATION_CODE;
        }
        Redis::setex($phone_code_key,self::VERIFICATION_CODE_TIME,$code);
        Redis::setex($limited_key,self::LIMIT_TIME,1);
        return Lib_const_status::SUCCESS;
    }

    /**
     * 验证redis验证码 是否正确
     * @param $phone
     * @param $code
     * @return int
     */
    public static function VerificationCode($phone,$code){

        $phone_code_key = self::SplicingKey(self::VERIFICATION_CODE.$phone);
        $time_error_key = self::SplicingKey(self::TIME_ERROR.$phone);
        $error_time = Redis::get($time_error_key);
        if($error_time >= self::MAXIMUM_ATTEMPTS){
            Redis::del($time_error_key);
            Redis::del($phone_code_key);
        }

        $verification_code = Redis::get($phone_code_key);
        if(!$verification_code){
            return Lib_const_status::VERIFICATION_CODE_EXPIRED;
        }
        if($verification_code!=$code){
            Redis::incr($time_error_key);
            return Lib_const_status::VERIFICATION_CODE_ERROR;
        }else{
            Redis::del($time_error_key);
            Redis::del($phone_code_key);
            return Lib_const_status::SUCCESS;
        }

    }


}