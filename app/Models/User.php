<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'users';
    public $timestamps = false;
//    protected $dateFormat = 'U';//使用时间戳方式添加
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    // public $timestamps = false;
    protected $fillable = [
        'id','name','email','user_img','sex','access_token','expires_in','user_openid','created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        ''
    ];

    protected $select = ['user_id'];
    protected $select_info = ['id','name','email','user_img','sex','access_token','expires_in','user_openid'];

    // 添加新用户
    public function insert($param){
        $result = $this->create($param);
        return $result;
    }

    /**
     * 根据用户授权token  获取用户过期时间
     * @param $access_token
     * @return mixed
     */
    public function getByAccessToken($access_token){
        return $this->select('id','name','user_img','expires_in','user_openid')->where(['access_token'=>$access_token])->first();
    }


    /**
     * 通过id查询当前用户信息
     * @param $id
     * @return mixed
     */
    public function getUserInfo($id){
        return $this->select($this->select_info)->find($id);
    }

    // 查询当前用户 通过openid查询当前用户
    public function info($openid){
        return $this->where('user_openid',$openid)->first();
    }


    /**
     * 根据条件查询
     * @param $param
     * @return array
     */
    public  function getUserByWhere($param){
        $page = $param['page'];
        $limit = $param['limit'];
        $where = $param['cond'] ?? [];
        $sortfield = $param['sortField'] ?? 'id';
        $order = $param['order'] ?? 'asc';
        if ($where) $where = [['name', 'like', $where.'%']];
        $offset = ($page - 1) * $limit;

        $admins = $this->where($where)->select($this->select_info)
            ->offset($offset)->limit($limit)->orderBy($sortfield, $order)->get()->toArray();
        $count = $this->where($where)->count();
        return [
            'count' => $count,
            'data' => $admins
        ];
    }
}