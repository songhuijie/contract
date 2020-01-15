<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityInformation extends Model
{
    //
    protected $table = 'identity_information';
    public $timestamps = false;
    protected $dateFormat = 'U';//使用时间戳方式添加

    public $select = ['user_id', 'identity_card_positive', 'identity_card_back'];
    protected $primaryKey = 'user_id';


    public function getIdentityCardPositiveAttribute($value){

        return json_decode($value,true);
    }


    public function getIdentityCardBackAttribute($value){

        return json_decode($value,true);
    }
}
