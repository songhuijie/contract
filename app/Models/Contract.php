<?php

namespace App\Models;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contract extends Model
{
    //

    protected $table = 'contract';
    public $timestamps = false;
    protected $dateFormat = 'U';//使用时间戳方式添加

    public $select = ['id', 'user_id', 'specific_user_id', 'template_id', 'template_content','contract_title', 'contract_demand', 'first_is_sign', 'is_sign','contract_type', 'status','create_time','price', 'updated_at'];



    protected $primaryKey = 'id';

    protected $fillable = ['template_content','contract_title', 'contract_demand','first_is_sign','is_sign','status'];

    /**
     * 获取列表数据  后台获取
     * @param $param
     * @return array
     */
    public function getContract($param){
        $page = $param['page'];
        $limit = $param['limit'];
        $cond= $param['cond'] ?? '';
        $contract_type = $param['contract_type'] ?? '';

        $sortfield = $param['sortField'] ?? 'create_time';
        $order = $param['order'] ?? 'desc';
        $where = [];
        if ($cond)
            $where[] = ['key', 'like', $cond.'%'];

        if ($contract_type)
            $where[] = ['contract_type', '=',$contract_type];


        $offset = ($page - 1) * $limit;

        $admins = $this->with('templateTitle')->where($where)->select($this->select)
            ->offset($offset)->limit($limit)->orderBy($sortfield, $order)->get()->toArray();
        $count = $this->where($where)->count();
        return [
            'count' => $count,
            'data' => $admins
        ];
    }

    /**
     * 获取列表数据  api 获取
     * @param $param
     * @return array
     */
    public function getContractFromApi($param){
        $page = $param['page'];
        $limit = $param['limit'];
        $sortfield = $param['sortField'] ?? 'create_time';
        $order = $param['order'] ?? 'desc';
        $offset = ($page - 1) * $limit;

        $contract = $this;
        $user_id = $param['user_id'];
        switch ($param['status']){
            case 0:
                //0 全部合同(未签署)

                $contract = $contract->whereRaw('(`is_sign` != 1 or `first_is_sign` != 1) and (`specific_user_id` = ? or `user_id` = ?) ', [$user_id,$user_id]);
                break;
            case 1:
                //1 全部合同(签署)

                $contract = $contract->where(['user_id'=>$user_id,'contract_type'=>1,'is_sign'=>1,'first_is_sign'=>1])
                    ->orwhere(function($query) use($user_id){
                        $query->where(['specific_user_id'=>$user_id,'contract_type'=>1,'is_sign'=>1,'first_is_sign'=>1]);
                    })->orwhere(function($query) use($user_id){
                        $query->where(['user_id'=>$user_id,'contract_type'=>2,'status'=>4,'is_sign'=>1]);
                    });
                break;
            case 2:
                //2等待他人签署的

                $contract =  $contract->where(['user_id'=>$param['user_id'],'contract_type'=>1,'is_sign'=>0]);
                break;
            case 3:
                //3需要我签名的
                $contract = $contract->where(['specific_user_id'=>$user_id,'contract_type'=>1,'is_sign'=>0])
                    ->orwhere(function($q1) use($user_id){
                        $q1->Where(['user_id'=>$user_id,'contract_type'=>2,'status'=>3,'is_sign'=>0]);
                    });
                break;
            case 4:
                //4 我创建
                $contract =  $contract->where(['user_id'=>$param['user_id'],'contract_type'=>1]);
                break;
            case 5:
                //5 指向我签署
                $contract =  $contract->where(['specific_user_id'=>$param['user_id'],'contract_type'=>1]);
                break;
            case 6:
                //6 律师代写
                $contract =  $contract->where(['user_id'=>$param['user_id'],'contract_type'=>2]);
                break;
            default:
                break;
        }

        $contract_data = $contract->with('templateTitle')->select($this->select)
            ->offset($offset)->limit($limit)->orderBy($sortfield, $order)->get()->toArray();
        return $contract_data;
    }

    /**
     * 模板
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function templateTitle(){
        return $this->hasOne(Template::class,'id','template_id');
    }

    /**
     * 单独查询时
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function specificUserName(){
        return $this->hasOne(User::class,'id','specific_user_id')->select('name');
    }


    /**
     * 根据合同ID 和用户ID  获取
     * @param $contract_id
     * @param $user_id
     * @return mixed
     */
    public function getByUserAndID($contract_id,$user_id){
        $contract =$this->where(['id'=>$contract_id,'specific_user_id'=>$user_id,'contract_type'=>1,'is_sign'=>0])
            ->orwhere(function($query) use($contract_id,$user_id){
                $query->Where(['id'=>$contract_id,'user_id'=>$user_id,'contract_type'=>1,'first_is_sign'=>0]);
            })->orwhere(function($query) use($contract_id,$user_id){
                $query->Where(['id'=>$contract_id,'user_id'=>$user_id,'contract_type'=>2,'status'=>3,'is_sign'=>0]);
            });
        return $contract->first();
    }


    /**
     * 修改 第二种情况
     * @param $contract_id
     * @param $user_id
     * @return mixed
     */
    public function getByUseChange($contract_id){
        return $this->where(['id'=>$contract_id])->first();
    }

    /**
     * 签署订单
     * @param $contract_id
     * @param $sign
     * @return mixed
     */
    public function updateSign($contract_id,$sign,$type){
        return $this->where(['id'=>$contract_id])->update([$type=>$sign]);
    }

    /**
     * 代写订单签署
     * @param $contract_id
     * @param $sign
     * @return mixed
     */
    public function updateSignGhostWrite($contract_id,$sign){
        return $this->where(['id'=>$contract_id])->update(['user_id'=>$sign,'specific_user_id'=>$sign]);
    }

    /**
     * 根据律师代写 合同订单
     * @param $contract_id
     * @param $user_id
     * @return mixed
     */
    public function getContractByGhostWrite($contract_id,$user_id){
        return $this->where(['id'=>$contract_id,'user_id'=>$user_id,'contract_type'=>2])->first();
    }


    /**
     * 根据订单号 获取合同订单
     * @param $order_number
     * @return mixed
     */
    public function getContractByNumber($order_number){
        return $this->where(['order_number'=>$order_number])->first();
    }

    /**
     * 更改律师代写订单状态
     * @param $order_number
     * @param $status
     * @return mixed
     */
    public function updateStatus($order_number,$status){
        return $this->where(['order_number'=>$order_number])->update(['status'=>$status]);
    }
}
