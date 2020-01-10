<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/9
 * Time: 11:41
 */
namespace  App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Lib_config;
use App\Libraries\Lib_const_status;
use App\Libraries\Lib_make;
use App\Models\Contract;
use App\Models\Template;
use App\Services\AccessEntity;
use Illuminate\Http\Request;

class ContractController extends Controller {


    public $template;
    public $query;
    public $contract;
    public function __construct(Template $template,Contract $contract)
    {
        $this->template = $template;
        $this->contract = $contract;
    }

    /**
     * 合同模板
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function template(Request $request){

        $param = $request->all();
        $response_json = $this->initResponse();

        $param['page']  = isset($param['page'])?$param['page']:Lib_config::PAGE;
        $param['limit'] = isset($param['limit'])?$param['limit']:Lib_config::LIMIT;
        $data = $this->template->getTemplate($param);

        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $data['data'];
        return $this->response($response_json);


    }


    /**
     * 创建合同
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ContractCreation(Request $request){

        $param = $request->all();

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        $response_json = $this->initResponse();

        if(isset($param['contract_type']) && $param['contract_type'] == 1){
            $fromErr = $this->validatorFrom([
                'specific_user_id'=>'required',
                'template_id'=>'required',
                'template_content'=>'required',
                'contract_type'=>'required|in:1,2',
            ],[
                'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
                'in'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
            ]);
            if($fromErr){//输出表单验证错误信息
                return $this->response($fromErr);
            }

            if($user_id == $param['specific_user_id']){
                $response_json->status = Lib_const_status::CANNOT_SEND_TO_YOURSELF;
                return $this->response($response_json);
            }

        }else{
            $fromErr = $this->validatorFrom([
                'contract_title'=>'required',
                'contract_demand'=>'required',
                'contract_type'=>'required|in:1,2',
            ],[
                'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
                'in'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
            ]);
            if($fromErr){//输出表单验证错误信息
                return $this->response($fromErr);
            }
        }

        $param['user_id'] = $user_id;
        $param['create_time'] = time();
        $contract_id = $this->contract->insertGetId($param);

        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data->id = $contract_id;
        return $this->response($response_json);
    }


    /**
     * 根据条件获取 合同信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContract(Request $request){
        $param = $request->all();
        $fromErr = $this->validatorFrom([
            'status'=>'required|in:0,1,2,3,4,5',//0 获取合同(未签署)  1 获取合同(签署)  2等待他人签署的  3 我创建的系统模板  4 指向我签署的 系统模板  5 律师代写
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
            'in'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);

        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        $response_json = $this->initResponse();

        $param['user_id'] = $user_id;
        $data = $this->contract->getContractFromApi($param);
        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $data;
        return $this->response($response_json);

    }

    /**
     * 获取用户列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function userList(){

        $response_json = $this->initResponse();

        $user_list = Lib_make::getUserList();

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        if(isset($user_list[$user_id])){
            unset($user_list[$user_id]);
        }
        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $user_list;
        return $this->response($response_json);

    }
}