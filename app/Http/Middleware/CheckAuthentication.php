<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/13
 * Time: 13:19
 */

namespace App\Http\Middleware;

use App\Libraries\Lib_const_status;
use App\Models\Certification;
use App\Service\AccessEntity;
use Closure;

/**
 * 实名认证
 * Class CheckAuthentication
 * @package App\Http\Middleware
 */
class CheckAuthentication{

    public function handle($request, Closure $next)
    {
        $access_entity = AccessEntity::getInstance();

        $certification = new Certification();
        $user_id = $access_entity->user_id;
        $authentication = $certification->find($user_id);

        if($authentication && $authentication->status == 1){
            return $next($request);
        }else{
            $response_object = new \stdClass();
            $response_object->code = Lib_const_status::CORRECT;
            $response_object->status = Lib_const_status::NO_REAL_NAME_AUTHENTICATION_YET;
            $response_object->data = new \StdClass();
            return response()->json($response_object);
        }
    }
}