<?php

namespace App\Models;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    //
    protected $table = 'refund';
    public $timestamps = false;
    protected $dateFormat = 'U';//使用时间戳方式添加
    public $select = ['user_id', 'price', 'order_number','status','created_at'];

    protected $primaryKey = 'id';

    public $fillable = ['status'];
    /**
     * 用户名
     */
    public function userName(){
        $this->belongsTo(User::class,'id','user_id');
    }

    public  function getRefund($param){
        $page = $param['page'];
        $limit = $param['limit'];
        $where = $param['cond'] ?? [];
        $sortfield = $param['sortField'] ?? 'user_id';
        $order = $param['order'] ?? 'asc';
        if ($where) $where = [['title', 'like', $where.'%']];
        $offset = ($page - 1) * $limit;

        $admins = $this->with('userName')->where($where)->select($this->select)
            ->offset($offset)->limit($limit)->orderBy($sortfield, $order)->get()->toArray();
        $count = $this->where($where)->count();
        return [
            'count' => $count,
            'data' => $admins
        ];
    }

}
