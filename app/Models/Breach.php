<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breach extends Model
{
    //
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'breach';
    public $timestamps = false;
    protected $dateFormat = 'U';//使用时间戳方式添加



    public $select = ['id','executor_name','sex','age','ID_card','province','executor_court','case_number','register_time'];


    public function getRegisterTimeAttribute($value){
        return date('Y-m-d H:i:s',$value);
    }

    public function getReleaseTimeAttribute($value){
        return date('Y-m-d H:i:s',$value);
    }

    /**
     * 分页搜索
     * @param $param
     * @return array
     */
    public  function getBreach($param){
        $page = $param['page'];
        $limit = $param['limit'];
        $cond = $param['cond'] ?? [];
        $identity = $param['identity'] ?? [];
        $city = $param['city'] ?? [];
        $search = $param['search'] ?? [];
        $sortfield = $param['sortField'] ?? 'id';
        $order = $param['order'] ?? 'asc';


       $breach = $this;

        if (!empty($cond)) {
            $breach = $breach->where('executor_name', 'like', "$cond%");
        }
        if($identity){
            $breach =  $breach->where('executor_name',$identity)->orWhere('ID_card', $identity);
        }
        if ($search) {
            $breach =  $breach->where('case_number',$search);
        }
        if ($city) {
            $breach =  $breach->where('province', 'like', "%$city%");
        }

        $offset = ($page - 1) * $limit;
        $admins = $breach->select($this->select)->offset($offset)->limit($limit)->orderBy($sortfield, $order)->get()->toArray();
        $count = $breach->count();
        return [
            'count' => $count,
            'data' => $admins
        ];
    }


    /**
     * 根据ID 数组获取信息
     * @param $ids
     * @return mixed
     */
    public function getByIds($ids){
            return $this->select($this->select)->whereIn('id',$ids)->get();
    }


}
