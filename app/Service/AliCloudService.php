<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/14
 * Time: 15:48
 */
namespace App\Service;

class AliCloudService{


    const IDENTITY_URL = "https://dm-51.data.aliyun.com/rest/160601/ocr/ocr_idcard.json";
    const MARKET_URL = "https://shixin.market.alicloudapi.com";
    const APP_KEY = 203779624;
    const APP_SECRET = 'zbwypo772dfo0cr5vecv37gn7nxiscse';
    const APP_CODE = '1b8430199f174b49bdec7a07ef91b72d';



    /**
     * 身份验证
     * 印刷文字识别-身份证识别/OCR文字识别（新年特惠，限时3折）
     * https://market.aliyun.com/products/57124001/cmapi010401.html?spm=5176.10695662.1996646101.searchclickresult.5d26733eytxS5W&aly_as=ebMDG592#sku=yuncode440100000
     * @param $file_path
     */
    public static function Identity($file_path){
        $url = self::IDENTITY_URL;
        $appcode = self::APP_CODE;
        $file = $file_path;
        //如果输入带有inputs, 设置为True，否则设为False
        $is_old_format = false;
        //如果没有configure字段，config设为空
        $config = array(
            "side" => "face"
        );
        //$config = array()


        if($fp = fopen($file, "rb", 0)) {
            $binary = fread($fp, filesize($file)); // 文件读取
            fclose($fp);
            $base64 = base64_encode($binary); // 转码
        }
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
        $querys = "";
        if($is_old_format == TRUE){
            $request = array();
            $request["image"] = array(
                "dataType" => 50,
                "dataValue" => "$base64"
            );

            if(count($config) > 0){
                $request["configure"] = array(
                    "dataType" => 50,
                    "dataValue" => json_encode($config)
                );
            }
            $body = json_encode(array("inputs" => array($request)));
        }else{
            $request = array(
                "image" => "$base64"
            );
            if(count($config) > 0){
                $request["configure"] = json_encode($config);
            }
            $body = json_encode($request);
        }
        $method = "POST";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$url, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        $result = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $rheader = substr($result, 0, $header_size);
        $rbody = substr($result, $header_size);

        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        if($httpCode == 200){
            if($is_old_format){
                $output = json_decode($rbody, true);
                $result_str = $output["outputs"][0]["outputValue"]["dataValue"];
            }else{
                $result_str = $rbody;
            }
            printf("result is :\n %s\n", $result_str);
        }else{
            printf("Http error code: %d\n", $httpCode);
            printf("Error msg in body: %s\n", $rbody);
            printf("header: %s\n", $rheader);
        }
    }

    /**
     * 失信查询
     * market
     * https://market.aliyun.com/products/57126001/cmapi017764.html?spm=5176.2020520132.101.3.4e0972188pJaRB#sku=yuncode1176400006
     * @param $realname
     * @param null $idcard
     * @return mixed
     */
    public static function market($realname,$idcard = null){
        $host = self::MARKET_URL;
        $path = "/creditblacklist/query";
        $method = "GET";
        $appcode = self::APP_CODE;
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);

        $realname = urlencode($realname);
        if($idcard){
            $querys = "realname=$realname";
        }else{
            $querys = "idcard=$idcard&realname=$realname";
        }
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
}