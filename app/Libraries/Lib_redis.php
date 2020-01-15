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


    const CONFIG = ':config';//配置
    const TEMPLATE = ':template';//模板列表
    const USER_LIST = ':user:list';//用户列表
    const VERIFICATION_CODE = ':verification:code:';//验证码
    const TIME_ERROR = ':time:error:';//验证码错误次数
    const LIMITED_TIME = ':limited:time:';//手机号限制时间发送
    const SUCCESSFUL = ':successful:state:';//手机号验证成功状态
    const SEARCH_HISTORY = ':search:history';//搜索历史 （暂时废除）


    //发送验证码 限制1分钟（可能不会有1分钟加请求返回时间 设定50秒）
    const LIMIT_TIME = 50;
    //验证码存活时间10分钟
    const VERIFICATION_CODE_TIME = 600;
    //验证码最大尝试次数
    const MAXIMUM_ATTEMPTS = 3;
    //验证成功后存储验证状态(10分钟)
    const SUCCESSFUL_STATE_TIME = 600;

    public static function SplicingKey($key){
        return config('app.redis_key_prefix','contract').$key;
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
     * 验证redis验证码 是否正确 验证成功后存储半个小时验证状态(半个小时候不用再次验证 可更改)
     * @param $phone
     * @param $code
     * @param $bool
     * @return int
     */
    public static function VerificationCode($phone,$code,$bool = true){

        //如果要每次验证 $bool 传false
        if($bool == false){
            return self::HandleVerification($phone,$code);
        }else{
            return self::HandleStateVerification($phone,$code);
        }

    }

    /**
     * 处理验证 保存下次可不验证
     * @param $phone
     * @param $code
     * @return int
     */
    public static function HandleStateVerification($phone,$code){
        $successful_key = self::SplicingKey(self::SUCCESSFUL.$phone);
        if(Redis::ttl($successful_key) > 0){
            return Lib_const_status::SUCCESS;
        }else{
            $phone_code_key = self::SplicingKey(self::VERIFICATION_CODE.$phone);
            $time_error_key = self::SplicingKey(self::TIME_ERROR.$phone);
            $error_time = Redis::get($time_error_key);
            if($error_time >= self::MAXIMUM_ATTEMPTS){
                Redis::del($time_error_key);
                Redis::del($phone_code_key);
            }

            $verification_code = Redis::get($phone_code_key);
//            dump($verification_code);//打印发送的验证码
            if(!$verification_code){
                return Lib_const_status::VERIFICATION_CODE_EXPIRED;
            }
            if($verification_code!=$code){
                Redis::incr($time_error_key);
                return Lib_const_status::VERIFICATION_CODE_ERROR;
            }else{
                Redis::del($time_error_key);
                Redis::del($phone_code_key);
                Redis::setex($successful_key,self::SUCCESSFUL_STATE_TIME,1);
                return Lib_const_status::SUCCESS;
            }
        }
    }

    /**
     * 处理每次验证
     * @param $phone
     * @param $code
     * @return int
     */
    public static function HandleVerification($phone,$code){

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