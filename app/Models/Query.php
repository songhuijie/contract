<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    //

    protected $table = 'query_log';
    public $timestamps = false;
    protected $dateFormat = 'U';//使用时间戳方式添加



    public function getByUserId($user_id){
        return $this->where('user_id',$user_id)->first();
    }

}
