<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/10
 * Time: 16:38
 */
namespace App\Service;
use AlicFeng\IdentityCard\IdentityCard;

class IdentityService{

    /**
     * 匹配身份证信息
     * @param $ID_card
     * @return bool
     */
    public static function MatchIdentityInformation($ID_card){

        $bool = IdentityCard::validate($ID_card);

        return $bool;
    }

}