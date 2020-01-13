<?php
/**
 * @return bool
 * 主动判断是否HTTPS
 */
function isHTTPS()
{
    if (defined('HTTPS') && HTTPS) return true;
    if (!isset($_SERVER)) return FALSE;
    if (!isset($_SERVER['HTTPS'])) return FALSE;
    if ($_SERVER['HTTPS'] === 1) {  //Apache
        return TRUE;
    } elseif ($_SERVER['HTTPS'] === 'on') { //IIS
        return TRUE;
    } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
        return TRUE;
    }
    return FALSE;
}

/**
 * 返回当前域名
 */
function nowUrl(){
    $host = (isHTTPS() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; //获取域名
    return $host;
}

function ajaxSuccess(array $data = [], $meta = '', string $msg = 'success', int $httpCode = 200)
{
    $return = [
        'code' => 0,
        'status' => 0,
        'msg' => $msg,
        'data' => $data,
        'meta' => $meta
    ];
    return response()->json($return, $httpCode);
}

function ajaxError(string $errMsg = 'error', int $httpCode = 200)
{
    $return = [
        'code' => 0,
        'status' => $httpCode,
        'msg' => $errMsg
    ];
    return response()->json($return, 200);
}


/**
 * @param $appid
 * @param $secret
 * @param $code
 * @return mixed
 * 通过小程序的code获取openid
 */
function getOpenid($appid,$secret,$code){
    $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";
    $data = curlGet($url);
    if($data){
        $result = json_decode($data,true);
        $url3 = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
        $result_two_json = curlGet($url3);
        $result_two = json_decode($result_two_json,true);
        $own_data = [
            'openid'=>$result['openid'],
            'access_token'=>$result_two['access_token'],
        ];
        return $own_data;
    }
    die();
}

/**
 * @param $appid
 * @param $secret
 * @return mixed
 * 小程序获取accesstoken
 */
function accessToken($appid,$secret){
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}&grant_type=client_credential";
    $result = curlGet($url);
    $data = json_decode($result,true);
    return $data['access_token'];
}


/**
 * 生成小程序二维码
 * @param $appid
 * @param $secret
 * @param $filePath
 * @param $smallPath
 * @param $scene
 * @param $accesstoken
 * @return string
 */
function QRcode($appid,$secret,$filePath,$smallPath,$scene,$accesstoken){
    $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$accesstoken;
    $data = [
        'scene' =>$scene,
        'page'=>$smallPath,
        'width' =>"200"
    ];
    $result = curlPost($url,json_encode($data));
    $filename = date('YmdHis',time())."_".rand().".png";
    file_put_contents($filePath.$filename,$result,true);
    return $filename;
}

/**
 * 生成透明小程序码
 * @param $appid
 * @param $secret
 * @param $filePath
 * @param $smallPath
 * @return string
 */
function smallQrcode($appid,$secret,$filePath,$smallPath){
    $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".accesstoken($appid,$secret);
    $data = [
        'page'=>$smallPath,
        'width' => "200",
        'is_hyaline'=>true,
    ];
    $result = curlPost($url,json_encode($data));
    $filename = date('YmdHis',time())."_".rand().".png";
    file_put_contents($filePath.$filename,$result,true);
    return $filename;
}
/**
 * 生成宣传海报
 * @param array  参数,包括图片和文字
 * @param string  $filename 生成海报文件名,不传此参数则不生成文件,直接输出图片
 * @return [type] [description]
 */
function createPoster($config=array(),$filename=""){
    //如果要看报什么错，可以先注释调这个header
    if(empty($filename)) header("content-type: image/png");
    $imageDefault = array(
        'left'=>0,
        'top'=>0,
        'right'=>0,
        'bottom'=>0,
        'width'=>100,
        'height'=>100,
        'opacity'=>100
    );
    $textDefault = array(
        'text'=>'',
        'left'=>0,
        'top'=>0,
        'fontSize'=>32,       //字号
        'fontColor'=>'255,255,255', //字体颜色
        'angle'=>0,
    );
    $background = $config['background'];//海报最底层得背景
    //背景方法
    $backgroundInfo = getimagesize($background);
    $backgroundFun = 'imagecreatefrom'.image_type_to_extension($backgroundInfo[2], false);
    $background = $backgroundFun($background);
    $backgroundWidth = imagesx($background);  //背景宽度
    $backgroundHeight = imagesy($background);  //背景高度
    $imageRes = imageCreatetruecolor($backgroundWidth,$backgroundHeight);
    $color = imagecolorallocate($imageRes, 0, 0, 0);
    imagefill($imageRes, 0, 0, $color);
    // imageColorTransparent($imageRes, $color);  //颜色透明
    imagecopyresampled($imageRes,$background,0,0,0,0,imagesx($background),imagesy($background),imagesx($background),imagesy($background));
    //处理了图片
    if(!empty($config['image'])){
        foreach ($config['image'] as $key => $val) {
            $val = array_merge($imageDefault,$val);
            $info = getimagesize($val['url']);
            $function = 'imagecreatefrom'.image_type_to_extension($info[2], false);
            if($val['stream']){   //如果传的是字符串图像流
                $info = getimagesizefromstring($val['url']);
                $function = 'imagecreatefromstring';
            }
            $res = $function($val['url']);
            $resWidth = $info[0];
            $resHeight = $info[1];
            //建立画板 ，缩放图片至指定尺寸
            $canvas=imagecreatetruecolor($val['width'], $val['height']);
            imagefill($canvas, 0, 0, $color);
            //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
            imagecopyresampled($canvas, $res, 0, 0, 0, 0, $val['width'], $val['height'],$resWidth,$resHeight);
            $val['left'] = $val['left']<0?$backgroundWidth- abs($val['left']) - $val['width']:$val['left'];
            $val['top'] = $val['top']<0?$backgroundHeight- abs($val['top']) - $val['height']:$val['top'];
            //放置图像
            imagecopymerge($imageRes,$canvas, $val['left'],$val['top'],$val['right'],$val['bottom'],$val['width'],$val['height'],$val['opacity']);//左，上，右，下，宽度，高度，透明度
        }
    }
    //处理文字
    if(!empty($config['text'])){
        foreach ($config['text'] as $key => $val) {
            $val = array_merge($textDefault,$val);
            list($R,$G,$B) = explode(',', $val['fontColor']);
            $fontColor = imagecolorallocate($imageRes, $R, $G, $B);
            $val['left'] = $val['left']<0?$backgroundWidth- abs($val['left']):$val['left'];
            $val['top'] = $val['top']<0?$backgroundHeight- abs($val['top']):$val['top'];
            imagettftext($imageRes,$val['fontSize'],$val['angle'],$val['left'],$val['top'],$fontColor,$val['fontPath'],$val['text']);
        }
    }
    //生成图片
    if(!empty($filename)){
        $res = imagejpeg ($imageRes,$filename,90); //保存到本地
        imagedestroy($imageRes);
        if(!$res) return false;
        return $filename;
    }else{
        imagejpeg ($imageRes);     //在浏览器上显示
        imagedestroy($imageRes);
    }
}


/**
 * @param $appid
 * @param $secret
 * @param $code
 * @return mixed
 * 通过公众号的code获取openid
 */
function getWChatOpenid($appid,$secret,$code){
    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code";
    $data = curlGet($url);
    if($data){
        $result = json_decode($data,true);
        return $result;
    }
    die();
}
// 获取用户信息
function getUserInfo($access_token,$openid){
    $url ="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
    $data = curlGet($url);
    if($data){
        $result = json_decode($data,true);
        return $result;
    }
    die();
}
// 获取access_token  公众号获取toke
function getAccess_token($appid,$secret){
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
    $data = curlGet($url);
    if($data){
        $result = json_decode($data,true);
        return $result;
    }
    die();
}

/**
 * 返回值
 */
function ReCode($code,$msg,$data,$count=0){
    return ['code'=>$code,'msg'=>$msg,'data'=>$data,'count'=>$count];
}
/**
 * api数据接口
 */
/**
 * 小程序支付
 * @param $amountmoney
 * @param $ordernumber
 * @param $openid
 * @param $appid
 * @param $mch_id
 * @param $mer_secret
 * @param $notify_url
 * @param $body
 * @param $attach
 * @return array
 */
function initiatingPayment($amountmoney,$ordernumber,$openid,$appid,$mch_id,$mer_secret,$notify_url,$body,$attach)
{
    $noncestr = createNonceStr(); //随机字符串
    $ordercode = $ordernumber;//商户订单号
    $totamount = $amountmoney;//金额
    $timeStamp = '' . time() . '';
    $data = [
        'openid' => $openid,
        'appid' => $appid,
        'mch_id' => $mch_id,
        'nonce_str' => $noncestr, //随机字符串,
        'body' => $body,
        'attach' => $attach,
        'timeStamp' => $timeStamp,
        'out_trade_no' => $ordercode,
        'total_fee' => intval($totamount * 100),
        'spbill_create_ip' => getIp(),
        'notify_url' => $notify_url,
        'trade_type' => 'JSAPI'
    ];
    //签名
    $data['sign'] = autograph($data,$mer_secret);
    $result = creatPay($data);
    $rest = xmlToArray($result);
    \Illuminate\Support\Facades\Log::info(json_encode($rest));
    if(!isset($rest['prepay_id'])){
        return false;
    }
    $prepay_id = $rest['prepay_id'];
    $parameters = array(
        'appId' => $appid, //小程序ID
        'timeStamp' => $timeStamp, //时间戳
        'nonceStr' => $noncestr, //随机串
        'package' => 'prepay_id=' . $prepay_id, //数据包
        'signType' => 'MD5'//签名方式
    );
    $sign = autograph($parameters,$mer_secret);
    return ['prepay_id' => 'prepay_id=' . $prepay_id, 'timeStamp' => $timeStamp, 'noncestr' => $noncestr, 'sign' => $sign, 'sign_type' => 'MD5'];
}

/**
 * 创建支付
 */
function creatPay($data)
{
    $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    $xml = arrayToXml($data);
    $result = curlPost($url, $xml);
//      print_r(htmlspecialchars($xml));
    //$val = $this->doPageXmlToArray($result);
    return $result;
}

// 小程序退款接口
/**
 *@param $appid              小程序appid
 *@param $mchid              商户号
 *@param $out_trade_no       商户订单号
 *@param $out_refund_no      商户退款单号
 *@param $key_pem            证书路径
 *@param $cert_pem           证书路径
 *@param $mch_secret         支付密钥
 */
function refund($appid,$mchid,$out_trade_no,$out_refund_no,$total_fee,$refund_fee,$mch_secret,$key_pem=null,$cert_pem=null){
    $data = [
        'appid' =>$appid,
        'mch_id'=> $mchid,
        'nonce_str' => createNonceStr(), //随机字符串,
        'out_trade_no' => $out_trade_no,
        'out_refund_no'=>$out_refund_no,
        'total_fee' => intval($total_fee * 100),//订单总金额
        'refund_fee'=> intval($refund_fee * 100),//退款金额
    ];
    //签名
    $data['sign'] = autograph($data,$mch_secret);
    $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";
    $xml = arrayToXml($data);
    $rest = httpCurlPost($url,$xml,$key_pem,$cert_pem);
    $result = xmlToArray($rest);
    return $result;
}

/**
 * @param $data
 * @return string
 * 生成签名
 */
function autograph($data,$mer_secret)
{
    $str = '';
    $data = array_filter($data);
    ksort($data);
    foreach ($data as $key => $value) {
        $str .= $key . '=' . $value . '&';
    }
    $str .= 'key=' . $mer_secret;
    return strtoupper(md5($str));
}

/**
 * @param int $length
 * @return string
 * 生成随机字符串
 */
function createNonceStr($length = 16)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

/**
 * @param $arr
 * @return string
 * 数组转xml
 */
function arrayToXml($arr)
{
    $xml = "<xml>";
    foreach ($arr as $key => $val) {
        if (is_array($val)) {
            $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
        } else {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        }
    }
    $xml .= "</xml>";
    return $xml;
}

/**
 * @param $xml
 * @return mixed
 * xml转数组
 */
function xmlToArray($xml)
{
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);

    $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

    $val = json_decode(json_encode($xmlstring), true);

    return $val;
}

/**
 * 退款双向证书curl
 */
function  httpCurlPost($url,$xml,$key_pem=null,$cert_pem=null){
    $ch = curl_init();
    // 设置URL和相应的选项
    curl_setopt($ch, CURLOPT_ENCODING, '');                     //设置header头中的编码类型
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);             //返回原生的（Raw）内容
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);            //禁止验证ssl证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);                        //header头是否设置
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSLCERTTYPE,'PEM');
    curl_setopt($ch, CURLOPT_SSLCERT, $cert_pem?$cert_pem:'cert/apiclient_cert.pem');
    curl_setopt($ch, CURLOPT_SSLKEYTYPE,'PEM');
    curl_setopt($ch, CURLOPT_SSLKEY, $key_pem?$key_pem:'cert/apiclient_key.pem');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    $tmpInfo = curl_exec($ch);
    //返回api的json对象
    //关闭URL请求
    curl_close($ch);
    return $tmpInfo;    //返回json对象
}

/**
 * 企业转账到零钱
 */
function transferAccounts($appid,$mchid,$openid,$desc,$partner_trade_no,$amount,$mch_secret,$key_pem=null,$cert_pem=null){
    $data = [
        'mch_appid' =>$appid,
        'mchid'=> $mchid,
        'openid' => $openid,
        'nonce_str' => createNonceStr(), //随机字符串,
        'desc' => $desc,
        'check_name'=>'NO_CHECK',
        'partner_trade_no' => $partner_trade_no,
        'amount' => intval($amount * 100),
        'spbill_create_ip' => getIp(),
    ];
    //签名
    $data['sign'] = autograph($data,$mch_secret);
    $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
    $xml = arrayToXml($data);
    $rest = httpCurlPost($url,$xml,$key_pem,$cert_pem);
    $result = xmlToArray($rest);
    return $result;
}

/**
 * @return array|false|mixed|string
 * u获取ip地址
 */
function getIp(){
    $onlineip='';
    if(getenv('HTTP_CLIENT_IP')&&strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')){
        $onlineip=getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR')&&strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown')){
        $onlineip=getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR')&&strcasecmp(getenv('REMOTE_ADDR'),'unknown')){
        $onlineip=getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR'])&&$_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')){
        $onlineip=$_SERVER['REMOTE_ADDR'];
    }
    return $onlineip;
}

/**
 * @param $arr
 * @param $key
 * @return array
 * 二维数组根据某个字段去重
 */
function array_unset_tt($arr, $key){
    //建立一个目标数组
    $res = array();
    foreach ($arr as $value) {
        //查看有没有重复项
        if (isset($res[$value[$key]])) {
            //有：销毁
            unset($value[$key]);
        } else {
            $res[$value[$key]] = $value;
        }
    }
    return $res;
}


/**
 * @param $url
 * @return mixed
 * curl模拟get请求
 */
function curlGet($url){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
    $tmpInfo = curl_exec($curl);     //返回api的json对象
    //关闭URL请求
    curl_close($curl);
    return $tmpInfo;    //返回json对象
}

function curlInfoPost($url){
    $postUrl = $url;
    $curlPost = '';
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);

    $j=json_decode($data);
    return $j;
}


/**
 * @param $url
 * @param $xml
 * @return mixed
 * curl 模拟post请求
 */
function curlPost($url, $xml)
{
    $ch = curl_init();
    //设置抓取的url
    curl_setopt($ch, CURLOPT_URL, $url);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $tmpInfo = curl_exec($ch);

    //返回api的json对象
    //关闭URL请求
    curl_close($ch);
    return $tmpInfo;    //返回json对象
}