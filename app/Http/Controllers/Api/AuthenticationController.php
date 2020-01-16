<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/9
 * Time: 13:51
 */
namespace  App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Lib_const_status;
use App\Libraries\Lib_make;
use App\Libraries\Lib_redis;
use App\Models\Certification;
use App\Models\Charter;
use App\Service\AccessEntity;
use App\Service\AliCloudService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller{

    public $certification;
    public $charter;
    public function __construct(Certification $certification,Charter $charter)
    {
        $this->certification = $certification;
        $this->charter = $charter;
    }


    /**
     * 用户认证
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function UserCertification(Request $request){

        $all = $request->all();
        $fromErr = $this->validatorFrom([
            'name'=>'required',
            'ID_card'=>'required|identity',
            'phone'=>'required|unique:certification',
            'code'=>'required',
            'identity_card_positive'=>'required',
            'identity_card_back'=>'required',
            'status'=>'in:1,2',
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
            'in'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
            'unique'=>Lib_const_status::PHONE_NUMBER_IS_BOUND,
            'identity'=>Lib_const_status::ID_CARD_INFORMATION_ERROR,
        ]);


        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }

        $response_json = $this->initResponse();
        $int = Lib_redis::VerificationCode($all['phone'],$all['code']);
        if($int != 0){
            $response_json->status = $int;
            return $this->response($response_json);
        }

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;

        $int = Lib_make::Identity($all['identity_card_positive'],$all['identity_card_back'],$user_id,$all['name'],$all['ID_card']);
        if($int != 0){
            $response_json->status = $int;
            return $this->response($response_json);
        }

        $status = $all['status']?$all['status']:1;
        $certification = $this->certification->find($user_id);



        unset($all['status'],$all['code']);
        if($status == 2){
            if($certification){
                $certification->update($all);
                $response_json->status = Lib_const_status::SUCCESS;
            }else{
                $response_json->status = Lib_const_status::USER_NOT_CERTIFICATION;
            }
        }else{
            if(!$certification){
                $all['user_id'] = $user_id;
                $all['status'] = 1;
                $this->certification->insert($all);
                $response_json->status = Lib_const_status::SUCCESS;
            }else{
                $response_json->status = Lib_const_status::USER_ALREADY_CERTIFICATION;
            }
        }

        return $this->response($response_json);

    }

    /**
     * 发送验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function SendVerificationCode(Request $request){
        $param = $request->all();
        $fromErr = $this->validatorFrom([
            'phone'=>'required|integer|mobile',
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
            'integer'=>Lib_const_status::MOBILE_NUMBER_FORMAT_ERROR,
            'mobile'=>Lib_const_status::MOBILE_NUMBER_FORMAT_ERROR,
        ]);

        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }

        $int = Lib_make::SendVerificationCode($param['phone']);

        $response_json = $this->initResponse();
        $response_json->status = $int;
        return $this->response($response_json);
    }


    /**
     * 添加印章数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function CreateSeal(Request $request){



        $all = $request->all();
        $response_json = $this->initResponse();
        if(!isset($all['charter_type'])){
            $response_json->status = Lib_const_status::ERROR_REQUEST_PARAMETER;
            return $this->response($response_json);
        }
        if($all['charter_type'] == 2){
            $fromErr = $this->validatorFrom([
                'name'=>'required',
                'ID_card'=>'required|identity',
                'company_name'=>'required',
                'certificate_number'=>'required',
                'official_seal_number'=>'required',
                'business_license'=>'required',
                'charter_pic'=>'required',
                'charter_type'=>'required|in:1,2',
            ],[
                'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
                'in'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
                'identity'=>Lib_const_status::ID_CARD_INFORMATION_ERROR,
            ]);
            if($fromErr){//输出表单验证错误信息
                return $this->response($fromErr);
            }
        }else{
            $fromErr = $this->validatorFrom([
                'name'=>'required',
                'ID_card'=>'required|identity',
                'charter_pic'=>'required',
                'charter_type'=>'required|in:1,2',
            ],[
                'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
                'in'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
                'identity'=>Lib_const_status::ID_CARD_INFORMATION_ERROR,
            ]);
            if($fromErr){//输出表单验证错误信息
                return $this->response($fromErr);
            }
        }

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;

        $all['user_id'] = $user_id;

        $charter = $this->charter->find($user_id);
        if($charter){
            $response_json->status = Lib_const_status::SEAL_ALREADY_EXISTS;
        }else{
            $this->charter->insert($all);
            $response_json->status = Lib_const_status::SUCCESS;
        }

        return $this->response($response_json);

    }

    /**
     * 获取印章
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSeal(Request $request){

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;

        $charter_pic = $this->charter->getCharterPic($user_id);

        $response_json = $this->initResponse();
        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $charter_pic;
        return $this->response($response_json);
    }
}