<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //

    protected $table = 'contract';
    public $timestamps = false;
    protected $dateFormat = 'U';//使用时间戳方式添加

    public $select = ['id', 'user_id', 'specific_user_id', 'template_id', 'template_content', 'is_sign', 'contract_type', 'status','create_time', 'updated_at'];

    protected $primaryKey = 'id';

    protected $fillable = ['is_sign','status'];

    /**
     * 获取列表数据  后台获取
     * @param $param
     * @return array
     */
    public function getContract($param){
        $page = $param['page'];
        $limit = $param['limit'];
        $where = $param['cond'] ?? [];
        $sortfield = $param['sortField'] ?? 'create_time';
        $order = $param['order'] ?? 'desc';
        if ($where) $where = [['key', 'like', $where.'%']];
        $offset = ($page - 1) * $limit;

        $admins = $this->where($where)->select($this->select)
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
        switch ($param['status']){
            case 0:
                //0 全部合同(未签署)
                $contract =  $contract->where(['user_id'=>$param['user_id'],'is_sign'=>0])->orWhere(['specific_user_id'=>$param['user_id'],'is_sign'=>0]);
                break;
            case 1:
                //1 全部合同(签署)
                $contract =  $contract->where(['user_id'=>$param['user_id'],'is_sign'=>1])->orWhere(['specific_user_id'=>$param['user_id'],'is_sign'=>1]);
                break;
            case 2:
                //2等待他人签署的
                $contract =  $contract->where(['user_id'=>$param['user_id'],'contract_type'=>1,'is_sign'=>0]);
                break;
            case 3:
                //3需要我签名的
                $contract =  $contract->where(['specific_user_id'=>$param['user_id'],'contract_type'=>1,'is_sign'=>0]);
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

        $contract_data = $contract->select($this->select)
            ->offset($offset)->limit($limit)->orderBy($sortfield, $order)->get()->toArray();
        return $contract_data;
    }


    /**
     * 根据合同ID 和用户ID  获取
     * @param $contract_id
     * @param $user_id
     * @return mixed
     */
    public function getByUserAndID($contract_id,$user_id){
        return $this->where(['id'=>$contract_id,'specific_user_id'=>$user_id,'contract_type'=>'1','is_sign'=>0])->first();
    }

    /**
     * 签署订单
     * @param $contract_id
     * @param $sign
     * @return mixed
     */
    public function updateSign($contract_id,$sign){
        return $this->where(['id'=>$contract_id])->update(['is_sign'=>$sign]);
    }
}