<?php

namespace App\Http\Controllers\Api;

use App\Jobs\SearchHistory;
use App\Libraries\Lib_config;
use App\Libraries\Lib_const_status;
use App\Libraries\Lib_make;
use App\Models\Breach;
use App\Models\Query;
use App\Services\AccessEntity;
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

        $all = $request->all();
        $fromErr = $this->validatorFrom([
            'city'=>'required',
        ],[
            'required'=>Lib_const_status::ERROR_REQUEST_PARAMETER,
        ]);

        if($fromErr){//输出表单验证错误信息
            return $this->response($fromErr);
        }
        $access_entity = AccessEntity::getInstance();
        $user_id = $access_entity->user_id;
        $response_json = $this->initResponse();

        $all['page'] = isset($all['page']) ?$all['page'] :Lib_config::PAGE;
        $all['limit'] = isset($all['limit']) ?$all['limit'] :Lib_config::LIMIT;

        $all['identity'] = isset($all['identity']) ?$all['identity'] : '';
        $all['search'] = isset($all['search']) ?$all['search'] : '';
        $all['city'] = $all['city'] == '全国' ?'':$all['city'];


        $data = $this->breach->getBreach($all);

        $array = (array) $data['data'];
        $ids = array_column($array,'id');
        //异步执行 保存历史
        SearchHistory::dispatch($user_id,$ids);

        $response_json->status = Lib_const_status::SUCCESS;
        $response_json->data = $data['data'];
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
