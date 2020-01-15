<?php
/**
 * Created by PhpStorm.
 * User: shj
 * Date: 2018/10/10
 * Time: 上午11:21
 */
namespace App\Libraries;

use App\Model\User;
use App\Models\Config;
use App\Models\IdentityInformation;
use App\Models\Template;
use App\Service\AliCloudService;
use Illuminate\Support\Facades\Redis;

class Lib_make{

    /**
     * 生成处理 配置信息
     * @param bool $bool
     * @return array|mixed
     */
    public static function getConfig($bool = true){
        $config = Redis::get(Lib_redis::SplicingKey(Lib_redis::CONFIG));
        if($bool == false){
            Redis::del(Lib_redis::SplicingKey(Lib_redis::CONFIG));
            self::getConfig();
        }else{
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


    /**
     * 根据用户ID获取 搜索历史
     * @param $user_id
     * @return array
     */
    public static function getSearchHistory($user_id){

        $empty_data = [];
        $history_search = Lib_redis::SplicingKey(Lib_redis::SEARCH_HISTORY);
        $history_data = Redis::get($history_search);

        if($history_data){
            $history_data = json_decode($history_data,true);
            if(isset($history_data[$user_id])){
                return $history_data[$user_id];
            }else{
                return $empty_data;
            }
        }
        return $empty_data;
    }

    /**
     * 处理用户历史搜索
     * @param $user_id
     * @param $ids
     */
    public static function HandleSearchHistory($user_id,$ids){

        $history_search = Lib_redis::SplicingKey(Lib_redis::SEARCH_HISTORY);
        $history_data = Redis::get($history_search);
//        $history_data = Redis::del($history_search);
//        dd(1);
        if($history_data){


            $history_data = json_decode($history_data,true);

            if(isset($history_data[$user_id])){
                $diff = array_diff($history_data[$user_id],$ids);
                $history_data[$user_id] = array_merge($ids,$diff);
                $data = $history_data;
            }else{
                $data[$user_id] = $ids;
            }
            Redis::set($history_search,json_encode($data));

        }else{
            $data[$user_id] = $ids;
            Redis::set($history_search,json_encode($data));
        }

    }

    /**
     * 获取用户列表  默认创建数据到redis  当为false 删除并创建
     * @param bool $bool
     * @return array|mixed
     */
    public static function getUserList($bool = true){


        $user_list_key = Lib_redis::SplicingKey(Lib_redis::USER_LIST);

        if($bool == false){
            Redis::del($user_list_key);
            self::getUserList();
        }else{

            $user_list = Redis::get($user_list_key);

            if($user_list){
                return json_decode($user_list,true);
            }else{
                $user = new User();

                $user_list = $user->select('id','name')->get()->toArray();

                $list = array_column($user_list,'name','id');
                Redis::set($user_list_key,json_encode($list));
                return $list;
            }
        }



    }

    /**
     * 获取模板信息
     * @param bool $bool
     * @return array|mixed
     */
    public static function getTemplate($bool = true){
        $template_key = Lib_redis::SplicingKey(Lib_redis::TEMPLATE);
        $template= Redis::get($template_key);
        if($bool == false){
            Redis::del($template_key);
            self::getTemplate();
        }else{
            if($template){
                return json_decode($template,true);
            }else{
                $template_model = new Template();
                $template_all = $template_model->all();
                $config = [];
                foreach($template_all as $k=>$v){
                    $config[$v->id] = $v->title;
                }
                Redis::setex($template_key,78200,json_encode($config));
                return $config;
            }
        }
    }


    /**
     * 发送验证码
     * @param $phone
     * @return int
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public static function SendVerificationCode($phone){

        $code = rand(100000,999999);//验证码
        $code_array = ['code'=>$code];
        $int = Lib_redis::sendVerificationCode($phone,$code);
        if($int == Lib_const_status::SUCCESS){
            $bool = AliCloudService::SendSms($phone,json_encode($code_array));//阿里云发送验证码
            if($bool == false){
                return Lib_const_status::SMS_SENDING_FAILED;
            }else{
                return Lib_const_status::SUCCESS;
            }
        }else{
            return $int;
        }
    }


    /**
     * 身份验证
     * @param $positive_path
     * @param $back_path
     * @param $user_id
     * @param $name
     * @param $ID_card
     * @return int
     */
    public static function Identity($positive_path,$back_path,$user_id,$name,$ID_card){

        $verification_name = false;
        $verification_ID_card = false;

        $positive_path = public_path().'/'.$positive_path;
        $positive_data = AliCloudService::Identity($positive_path);
        if($positive_data == false){
            return Lib_const_status::IDENTITY_POSITIVE_INFORMATION_IS_NOT_RECOGNIZED;
        }
        $verification_data = json_decode($positive_data,true);

        if(isset($verification_data['name']) && $verification_data['name'] == $name){
            $verification_name = true;
        }
        if(isset($verification_data['num']) && $verification_data['num'] == $ID_card){
            $verification_ID_card = true;
        }

        if($verification_name == false || $verification_ID_card == false){
            return Lib_const_status::IDENTITY_INFORMATION_DOES_NOT_MATCH;
        }

        $back_path = public_path().'/'.$back_path;
        $back_data = AliCloudService::Identity($back_path);
        if($back_data == false){
            return Lib_const_status::IDENTITY_BACK_INFORMATION_IS_NOT_RECOGNIZED;
        }
        $identityInformation_data = [
            'user_id'=>$user_id,
            'identity_card_positive'=>$positive_data,
            'identity_card_back'=>$back_data,
        ];
        $identityInformation = new IdentityInformation();
        $identityInformation->insert($identityInformation_data);
        return Lib_const_status::SUCCESS;


    }


}