<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    //
    //
    protected $table = 'certification';
    public $timestamps = false;
    protected $dateFormat = 'U';//使用时间戳方式添加
    public $select = ['user_id', 'name', 'ID_card', 'identity_card_positive','identity_card_back','status','updated_at'];


    protected $fillable = ['name','ID_card', 'identity_card_positive','identity_card_back'];

    public function getIdentityCardPositiveAttribute($value){

        return env('URL','http://127.0.0.1:8000/').$value;
    }

    public function getIdentityCardBackAttribute($value){

        return env('URL','http://127.0.0.1:8000/').$value;
    }


    protected $primaryKey = 'user_id';

    public  function getCertification($param){
        $page = $param['page'];
        $limit = $param['limit'];
        $where = $param['cond'] ?? [];
        $sortfield = $param['sortField'] ?? 'user_id';
        $order = $param['order'] ?? 'asc';
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
