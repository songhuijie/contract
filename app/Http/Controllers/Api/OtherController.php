<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/9
 * Time: 10:25
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Lib_config;
use App\Libraries\Lib_const_status;
use App\Libraries\Lib_make;
use App\Models\Notice;
use App\Models\Refund;
use App\Service\AccessEntity;
use Illuminate\Http\Request;

class OtherController extends Controller{

    public $notice;
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * 关于我们
     */
    public function aboutUs(){

        $response_json = $this->initResponse();


        $config = Lib_make::getConfig();

        $data = isset($config['aboutUs'])?$config['aboutUs']:'';

        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $data;
        return $this->response($response_json);

    }


    /**
     * 通知列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function notice(Request $request){

        $param = $request->all();

        $response_json = $this->initResponse();

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        $param['page'] = isset($param['page'])?$param['page']:Lib_config::PAGE;
        $param['limit'] = isset($param['limit'])?$param['limit']:Lib_config::LIMIT;
        $param['user_id'] = $user_id;
        $notice = $this->notice->getNotice($param);

        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $notice['data'];
        return $this->response($response_json);

    }

    /**
     * 查看通知
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request){

        $param = $request->all();
        $fromErr = $this->validatorFrom([
            'notice_id'=>'required',
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);

        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }

        $id = $param['notice_id'];

        $response_json = $this->initResponse();

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        $notice = $this->notice->find($id);
        if($notice){

            if($notice->user_id == $user_id){
                $notice->update(['status'=>1]);
            }
            $response_json->status = Lib_const_status::SUCCESS;
        }else{
            $response_json->status = Lib_const_status::NOTIFICATION_DOES_NOT_EXIST;
        }

        return $this->response($response_json);
    }


    /**
     * 获取 律师代写费用
     */
    public function getConfig(){
        $response_json = $this->initResponse();


        $config = Lib_make::getConfig();
        $price = isset($config['price'])?$config['price']:'';
        $rotation = [];
        if(isset($config['rotation'])){
            foreach(json_decode($config['rotation'],true) as $k=>$v){
                $rotation[] = config('app.url').$v;
            }
        }
        $attorney_instructions = [];
        if(isset($config['attorney_instructions'])){
            $attorney_instructions = json_decode($config['attorney_instructions'],true);
        }

        $data= [
            'price'=>$price,
            'rotation'=>$rotation,
            'instructions'=>$attorney_instructions,
        ];


        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $data;
        return $this->response($response_json);
    }
}