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
    public $select_search = ['user_id', 'name'];


    protected $fillable = ['name','ID_card', 'identity_card_positive','identity_card_back','status'];

    public function getIdentityCardPositiveAttribute($value){

        return config('app.url').$value;
    }

    public function getIdentityCardBackAttribute($value){

        return config('app.url').$value;
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

    //和身份信息表建立关系
    public function Information(){
        return $this->hasOne(IdentityInformation::class,'user_id','user_id');
    }

    /**
     * 根据手机号 获取用户来发送合同
     * @param $phone
     * @return mixed
     */
    public function getUserIDbyPhone($phone){
        return $this->select($this->select_search)->where('phone',$phone)->first();
    }
}
