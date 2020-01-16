<?php

namespace App\Http\Controllers\Api;

use App\Jobs\SearchHistory;
use App\Libraries\Lib_config;
use App\Libraries\Lib_const_status;
use App\Libraries\Lib_make;
use App\Models\Breach;
use App\Models\Query;
use App\Service\AccessEntity;
use App\Service\AliCloudService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BreachController extends Controller
{
    public $breach;
    public $query;
    public function __construct(Breach $breach,Query $query)
    {
        $this->breach = $breach;
        $this->query = $query;
    }


    /**
     * 失信人搜索
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function query(Request $request){

        $param = $request->all();
        $fromErr = $this->validatorFrom([
            'search'=>'required',
            'city'=>'required',
            'identity'=>'integer',
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);

        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }
        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        $response_json = $this->initResponse();

        //可选	身份证号或组织机构代码
        //必选	姓名或公司名称
        if(isset($param['identity'])){
            $result_json = AliCloudService::market($param['search'],$param['identity']);
        }else{
            $result_json = AliCloudService::market($param['search']);
        }

        $result = json_decode($result_json,true);
        switch ($result['status']){
            case 0:
                $data = $result['result']['list'];

                if($param['city'] != '全国'){
                    $tempArr = array_column($data, null, 'province');
                    $tmp = [];
                    foreach($tempArr as $k=>$v){
                        if($k == $param['city']){
                            $tmp[] = $v;
                        }
                    }
                    $data = $tmp;
                }
                foreach($data as &$v){
                    if(!isset($v['realname'])){
                        $v['realname'] = $param['search'];
                    }
                }
                $response_json->status = Lib_const_status::SUCCESS;
                $response_json->data = $data;
                break;
            case 210:
                $response_json->status = Lib_const_status::SUCCESS;
                break;
            default:
                $response_json->status = Lib_const_status::SERVICE_ERROR;
                break;
        }

//        $data = $this->breach->getBreach($all);

//        $array = (array) $data['data'];
//        $ids = array_column($array,'id');
        //异步执行 保存历史
//        SearchHistory::dispatch($user_id,$ids);



        return $this->response($response_json);


    }


    /**
     * 查看 失信人 详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request){
        $all = $request->all();
        $fromErr = $this->validatorFrom([
            'id'=>'required',
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);

        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }
        $response_json = $this->initResponse();

        $data = $this->breach->find($all['id']);

        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $data;
        return $this->response($response_json);

    }


    /**
     * 查看 搜索历史
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request){

        $response_json = $this->initResponse();

        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;

        $array = Lib_make::getSearchHistory($user_id);

        $data = $this->breach->getByIds($array);

        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $data;
        return $this->response($response_json);

    }
}
