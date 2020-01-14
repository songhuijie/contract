<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/9
 * Time: 11:41
 */
namespace  App\Http\Controllers\Api;

use App\Events\Notice;
use App\Http\Controllers\Controller;
use App\Libraries\Lib_config;
use App\Libraries\Lib_const_status;
use App\Libraries\Lib_make;
use App\Model\User;
use App\Models\Contract;
use App\Models\Template;
use App\Service\AccessEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContractController extends Controller {


    public $template;
    public $query;
    public $contract;
    public $user;
    public function __construct(Template $template,Contract $contract,User $user)
    {
        $this->template = $template;
        $this->contract = $contract;
        $this->user = $user;
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
     * 获取模板信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function templateContent(Request $request){
        $param = $request->all();
        $fromErr = $this->validatorFrom([
            'template_id'=>'required',//模板ID
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);
        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }

        $response_json = $this->initResponse();
        $content = $this->template->find($param['template_id'],['title','content']);
        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $content;
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

            $config = Lib_make::getConfig();
            $param['price'] = isset($config['price'])?$config['price']:Lib_config::LAWYER_WRITES_THE_PRICE;
            $param['order_number'] =  "XSK".date('YmdHis') ."R".str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT)."U".$user_id;//订单号
        }

        $draft_information = $access_entity->company_or_individual;
        $param['user_id'] = $user_id;
        $param['create_time'] = time();
        $param['draft_information'] = $draft_information;
        $contract_id = $this->contract->insertGetId($param);
        if($param['contract_type'] == 1){
            /**
             * 发送合同签署通知  创建合同甲方默认签署
             */
            $date = date('Y-m-d');
            $enterprise = $draft_information;
            $signatory = Lib_config::PARTY_A;
            $message = [
                'date'=>$date,
                'enterprise'=>$enterprise,
                'signatory'=>$signatory,
            ];
            event(new Notice($param['specific_user_id'],$message));
        }

        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data->id = $contract_id;
        return $this->response($response_json);
    }

    /**
     * 律师代写后 确认合同
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Confirm(Request $request){
        $param = $request->all();
        $fromErr = $this->validatorFrom([
            'contract_id'=>'required',//合同ID
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);
        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        $response_json = $this->initResponse();
        $contract = $this->contract->getContractByGhostWrite($param['contract_id'],$user_id);
        if($contract && $contract->status == Lib_config::CONTRACT_IN_WRITING){
            $contract->update(['status'=>Lib_config::CONTRACT_COMPLETE]);
            $response_json->status = Lib_const_status::SUCCESS;
        }else{
            $response_json->status = Lib_const_status::CONTRACT_CANNOT;
        }
        return $this->response($response_json);
    }

    /**
     * 结算  合同订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function PayOrder(Request $request){
        $param = $request->all();
        $fromErr = $this->validatorFrom([
            'contract_id'=>'required',//合同ID
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);
        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }

        $config = Lib_make::getConfig();
        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        $response_json = $this->initResponse();
        $contract = $this->contract->getContractByGhostWrite($param['contract_id'],$user_id);
        if($contract){
            //待支付
            if($contract->status == Lib_config::CONTRACT_TO_BE_PAID){
                $openid = $this->user->find($user_id);
                $money = $contract->price;
                $order_number =  $contract->order_number;
                $openid = $openid->user_openid;
                $appid       = $config['appid'];
                $mch_id      = $config['mch_id'];
                $mch_secret       = $config['mch_secret'];
                $notify_url  = url('api/v1/notify');//回调地址
                $body        = "小程序下单";
                $attach      = "用户下单";
                $data = initiatingPayment($money,$order_number,$openid,$appid,$mch_id,$mch_secret,$notify_url,$body,$attach);
                if($data == false){
                    Log::channel('error')->info(json_encode($data));
                    $response_json->status = Lib_const_status::ORDER_PAYMENT_FAILED;
                }else{
                    Log::channel('pay')->info(json_encode($data));
                    $response_json->status = Lib_const_status::SUCCESS;
                }
            }else{
                $response_json->status = Lib_const_status::ORDER_NOT_CONFIRMED;
            }

        }else{
            $response_json->status = Lib_const_status::SUCCESS;
        }

        return $this->response($response_json);
    }


    /**
     * 获取合同详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContractDetail(Request $request){
        $param = $request->all();

        $fromErr = $this->validatorFrom([
            'contract_id'=>'required',//合同ID
            'type'=>'required|in:1,2,3',//1表示获取系统模板合同或代写合同  2表示修改系统模板内容 3表示修改代写合同内容
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);
        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }


        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        $response_json = $this->initResponse();

        $contract = $this->contract->getByUseChange($param['contract_id'],$user_id);
        switch ($param['type']){
            case 1:

                $user_list = Lib_make::getUserList();
                 if(isset($user_list[$user_id])){
                     unset($user_list[$user_id]);
                 }
                if($contract){
                    $contract->templateTitle;
                    $contract->user_list = $user_list ;
                    $response_json->status = Lib_const_status::SUCCESS;
                    $response_json->data = $contract;
                }else{
                    $response_json->status = Lib_const_status::CONTRACT_CANNOT;
                }
                break;
            case 2:
                if($contract && $contract->contract_type == 1){
                    $contract->update($param);
                    $response_json->status = Lib_const_status::SUCCESS;
                }else{
                    $response_json->status = Lib_const_status::CONTRACT_CANNOT;
                }
                break;
            case 3:
                if($contract && $contract->contract_type == 2){
                    $contract->update($param);
                    $response_json->status = Lib_const_status::SUCCESS;
                }else{
                    $response_json->status = Lib_const_status::CONTRACT_CANNOT;
                }
                break;
            default:
                break;
        }

        return $this->response($response_json);

    }




    /**
     * 支付回调
     * @param Request $request
     */
    public function notify(Request $request){
        $value = file_get_contents("php://input"); //接收微信参数
        Log::channel('order')->info($value);

        if (!empty($value)) {
            $arr = xmlToArray($value);
            Log::channel('order')->info('支付成功回调成功');
            if($arr['result_code'] == 'SUCCESS' && $arr['return_code'] == 'SUCCESS'){
                $attach = json_decode($arr['attach'], true);
                $money = $arr['total_fee']/100;
                $uid = $attach['user_id'];
                $order_number = $arr['out_trade_no'];

                Log::channel('order')->info('支付成功回调成功');

                $contract_order = $this->contract->getContractByNumber($order_number);
                if($contract_order){
                    $this->contract->updateStatus($order_number,Lib_config::CONTRACT_SUCCESSFUL_PAYMENT);
                }

            }
        }
    }

    /**
     * 合同退款
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ContractRefund(Request $request){
        $param = $request->all();
        $fromErr = $this->validatorFrom([
            'contract_id'=>'required',//合同ID
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);
        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;

        $response_json = $this->initResponse();
        $contract = $this->contract->getContractByGhostWrite($param['contract_id'],$user_id);

        $response_json->status = Lib_const_status::SUCCESS;
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
            'status'=>'required|in:0,1,2,3,4,5,6',//0 合同(未签署)  1 合同(签署)  2等待他人签署的 3需要我签名的  4 我创建  5 指向我签署  6 律师代写
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
        $param['page']  = isset($param['page'])?$param['page']:Lib_config::PAGE;
        $param['limit'] = isset($param['limit'])?$param['limit']:Lib_config::LIMIT;
        $data = $this->contract->getContractFromApi($param);
        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $data;
        return $this->response($response_json);

    }


    /**
     * 签署
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sign(Request $request){
        $param = $request->all();
        $fromErr = $this->validatorFrom([
            'contract_id'=>'required',//0 合同(未签署)  1 合同(签署)  2等待他人签署的 3需要我签名的  4 我创建  5 指向我签署  6 律师代写
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);

        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }
        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        $response_json = $this->initResponse();

        $contract = $this->contract->getByUserAndID($param['contract_id'],$user_id);
        if($contract){
            $this->contract->updateSign($param['contract_id'],Lib_config::SIGN);
            //签署成功 通知

            $date = date('Y-m-d',$contract->create_time);
            $enterprise = $contract->draft_information;
            $signatory = Lib_config::PARTY_B;;
            $message = [
                'date'=>$date,
                'enterprise'=>$enterprise,
                'signatory'=>$signatory,
            ];
            event(new Notice($contract->user_id,$message));
            $response_json->status = Lib_const_status::SUCCESS;
        }else{
            $response_json->status = Lib_const_status::CONTRACT_CANNOT;
        }
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