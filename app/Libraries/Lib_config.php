<?php
/**
 * Created by PhpStorm.
 * User: shj
 * Date: 2018/10/10
 * Time: 上午11:21
 */
namespace App\Libraries;

class Lib_config{
    const SEARCH_LIMIT = 10;


    //签署 合同
    const SIGN = 1;


    const PAGE = 1;
    const LIMIT = 10;


    const LAWYER_WRITES_THE_PRICE = 100;

    const PARTY_A  = '甲方';
    const PARTY_B  = '乙方';

    //签字需要更新的字段
    const PARTY_A_TYPE = 'first_is_sign';
    const PARTY_B_TYPE = 'is_sign';


    const CONTRACT_TO_BE_PAID  = 0;  //合同待支付
    const CONTRACT_SUCCESSFUL_PAYMENT = 1; //合同支付成功
    const CONTRACT_IN_WRITING = 2;  //律师编写中
    const CONTRACT_COMPLETE = 3;   //确认完成


    const NOTIFICATION_TYPE_SIGN = 1;
    const NOTIFICATION_TYPE_IDENTITY = 2;



}