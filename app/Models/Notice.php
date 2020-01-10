<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    //
    protected $table = 'notice';
    public $timestamps = false;
    protected $dateFormat = 'U';//使用时间戳方式添加

    public $select = ['id', 'user_id', 'title', 'content', 'status', 'created_at'];

    protected $primaryKey = 'id';

    protected $fillable = ['status'];
    /**
     * 获取列表数据
     * @param $param
     * @return array
     */
    public function getNotice($param){
        $page = $param['page'];
        $limit = $param['limit'];
        $where = $param['cond'] ?? [];
        $sortfield = $param['sortField'] ?? 'created_at';
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
}
