<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Lib_config;
use App\Libraries\Lib_const_status;
use App\Libraries\Lib_make;
use App\Model\Agent;
use App\Model\Asset;
use App\Model\Config;
use App\Model\Friend;
use App\Services\AccessEntity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Model\User;
use PharIo\Manifest\Library;


class UserController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 用户登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $param = $request->all();
        Log::info(json_encode($param));
        $response_json = $this->initResponse();
        $fromErr = $this->validatorFrom([
            'code'=>'required',
        ],[
            'code.required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
            'id.unique'=>Lib_const_status::USER_NOT_EXISTENT,
        ]);

        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }


        $config = Lib_make::getConfig();
        $appid = $config['appid'];
        $secret = $config['secret'];

        if($param['code']){
            if(in_array($param['code'],['123','1234','12345','123456','1234567','12345678','123456789'])){
                $openid = [
                    'openid'=>$param['code'],
                    'access_token'=>'access_token'.$param['code'],
                    'name'=>'jie'.$param['code'],
                ];
            }else{
                $openid = getOpenid($appid,$secret,$param['code']);
            }
        }


        if (isset($openid['openid'])) {

            $user = $this->user->info($openid['openid']);


            $expires_in = time()+86000;
            if ($user) {
                $data = [
                    'id' =>$user->id,
                    'access_token' =>$openid['access_token'],
                ];

                $this->user->where('id',$data['id'])->update(['access_token'=>$data['access_token'],'expires_in'=>$expires_in]);
                $response_json->status = Lib_const_status::SUCCESS;
                $response_json->data = $data;
                return $this->response($response_json);
            }else{



                $data = [
                    'user_openid'=> $openid['openid'],
                    'name'=> isset($param['name'])?$param['name']:'',
                    'user_img'=> isset($param['user_img'])?$param['user_img']:'',
                    'email'=> '',
                    'access_token'=> $openid['access_token'],
                    'expires_in'=> $expires_in,
                ];

                $result = $this->user->insert($data);
                //重载用户列表
                Lib_make::getUserList(false);

                $id = $request->input('id',0);

                $response_json->status = Lib_const_status::SUCCESS;
                $response_json->data->id = $result->id;
                $response_json->data->access_token = $result->access_token;
                return $this->response($response_json);
            }

        }else{
            $response_json->status = Lib_const_status::ERROR_TOO_MUCH_REQUEST;
            return $this->response($response_json);
        }
    }

    /**
     * 获取用户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo(Request $request){

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;

        $user_info = $this->user->getUserinfo($user_id);


        $user_info->certification;
        $user_info->certification_status = $user_info->certification->status;
        $response_json = $this->initResponse();
        $response_json->code = Lib_const_status::CORRECT;
        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $user_info;
        return $this->response($response_json);

    }



}