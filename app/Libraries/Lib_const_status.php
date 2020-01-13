<?php
/**
 * Created by PhpStorm.
 * User: shj
 * Date: 2018/10/10
 * Time: 上午11:21
 */
namespace App\Libraries;

class Lib_const_status{
    const CORRECT = 0;
    const SUCCESS = 0;
    const SERVICE_ERROR = 1;
    const OTHER_ERROR = 2;
    //请求必要参数为空或者格式错误
    const ERROR_REQUEST_PARAMETER = 10;
    //请求过多,暂时被限制
    const ERROR_TOO_MUCH_REQUEST = 15;
    //用户token失效
    const USER_TOKEN_FAILURE = 10001;
    //用户不存在
    const USER_NOT_EXISTENT = 10002;
    //身份证信息错误
    const ID_CARD_INFORMATION_ERROR = 10003;
    //尚未实名认证
    const NO_REAL_NAME_AUTHENTICATION_YET = 10004;
    //需要创建个人印章或公司印章
    const NOT_YET_SEALED = 10005;
    //订单没有确认 或 已支付
    const ORDER_NOT_CONFIRMED = 10006;

    //通知不存在
    const NOTIFICATION_DOES_NOT_EXIST = 10012;
    //合同不能发送给自己
    const CANNOT_SEND_TO_YOURSELF = 10013;
    //合同不存在或已被签署
    const CONTRACT_CANNOT = 10015;

    //用户已认证
    const USER_ALREADY_CERTIFICATION = 20000;
    //用户未认证
    const USER_NOT_CERTIFICATION     = 20001;


    //印章已存在
    const SEAL_ALREADY_EXISTS     = 30000;





}