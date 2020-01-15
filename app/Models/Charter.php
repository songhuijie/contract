<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charter extends Model
{
    //
    protected $table = 'contract_charter';
    public $timestamps = false;
    protected $dateFormat = 'U';//使用时间戳方式添加
    public $select = ['user_id', 'name', 'ID_card','company_name','certificate_number','official_seal_number','business_license','charter_type','charter_pic'];

    protected $primaryKey = 'user_id';

    public function getCharterPicAttribute($value){
        return config('app.url','http://127.0.0.1:8000/').$value;
    }

    public  function getCharter($param){
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

    /**
     * 获取印章图片
     * @param $user_id
     * @return mixed
     */
    public function getCharterPic($user_id){
        return $this->where('user_id',$user_id)->value('charter_pic');
    }
}
