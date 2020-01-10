<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //
    protected $table = 'template';
    public $timestamps = false;
    protected $dateFormat = 'U';//使用时间戳方式添加
    public $select = ['id', 'title', 'sort', 'content'];

    public  function getTemplate($param){
        $page = $param['page'];
        $limit = $param['limit'];
        $where = $param['cond'] ?? [];
        $sortfield = $param['sortField'] ?? 'sort';
        $order = $param['order'] ?? 'desc';
        if ($where) $where = [['title', 'like', $where.'%']];
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

