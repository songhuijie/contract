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

    protected $fillable = ['status'];

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

        //`user_id` int(11) NOT NULL COMMENT '用户ID',
        //  `specific_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '指定用户ID',
        //  `template_id` int(11) NOT NULL DEFAULT '0' COMMENT '模板ID',
        //  `template_content` text COLLATE utf8mb4_unicode_ci COMMENT '模板编辑后内容',
        //  `contract_title` text COLLATE utf8mb4_unicode_ci COMMENT '合同名称',
        //  `contract_demand` text COLLATE utf8mb4_unicode_ci COMMENT '需求描述',
        //  `is_sign` int(11) NOT NULL DEFAULT '0' COMMENT '是否签署 0 未签署  1签署',
        //  `contract_type` int(11) NOT NULL DEFAULT '1' COMMENT '合同类型 1系统模板 2律师代写',
        //  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 待支付 1 支付成功',
        //  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '合同创建时间',

        //0 获取合同(未签署)  1 获取合同(签署)  2等待他人签署的  3 我创建的系统模板  4 指向我签署的 系统模板  5 律师代写
        $contract = $this;
        switch ($param['status']){
            case 0:
                $contract =  $contract->where(['user_id'=>$param['user_id'],'contract_type'=>1,'is_sign'=>0]);
                break;
            case 1:
                $contract =  $contract->where(['user_id'=>$param['user_id'],'contract_type'=>1,'is_sign'=>1]);
                break;
            case 2:
                $contract =  $contract->where(['specific_user_id'=>$param['user_id'],'contract_type'=>1,'is_sign'=>0]);
                break;
            case 3:
                break;
            case 4:
                break;
            case 5:
                break;
            default:
                break;
        }

        $contract_data = $contract->select($this->select)
            ->offset($offset)->limit($limit)->orderBy($sortfield, $order)->get()->toArray();
        return $contract_data;
    }
}
