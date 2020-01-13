<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/13
 * Time: 13:27
 */
namespace App\Http\Middleware;

use App\Libraries\Lib_const_status;
use App\Models\Charter;
use App\Service\AccessEntity;
use Closure;
/**
 * 检查印章
 * Class CheckAuthentication
 * @package App\Http\Middleware
 */
class CheckSeal{


    public function handle($request, Closure $next)
    {
        $access_entity = AccessEntity::getInstance();

        $charter = new Charter();
        $user_id = $access_entity->user_id;
        $charter = $charter->find($user_id);

        if($charter){
            //COMMENT '类型 1个人 2 公司'
            if($charter->charter_type == 1){
                $access_entity->company_or_individual = $charter->name;
            }else{
                $access_entity->company_or_individual = $charter->company_name;
            }
            return $next($request);
        }else{
            $response_object = new \stdClass();
            $response_object->code = Lib_const_status::CORRECT;
            $response_object->status = Lib_const_status::NOT_YET_SEALED;
            $response_object->data = new \StdClass();
            return response()->json($response_object);
        }
    }

}