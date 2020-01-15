<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/8
 * Time: 10:03
 */

namespace App\Http\Controllers;

use App\Libraries\Lib_config;
use App\Libraries\Lib_const_status;
use App\Libraries\Lib_make;
use App\Libraries\Lib_redis;
use App\Service\AliCloudService;
use App\Service\IdentityService;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller{


    public function test(){



//        $phone= 18080952663;
//        $code = rand(100000,999999);
//        $int = Lib_redis::sendVerificationCode($phone,$code);
//
//        dd($int,$code);

        dd(config('URL'));
        $phone = 18080952663;
        $code = 256630;
//        $int = Redis::get(Lib_redis::SplicingKey(Lib_redis::SUCCESSFUL.$phone));
//        $path = public_path().'/'.'uploads/id_card/1578905037223422.jpg';

//        $int = AliCloudService::Identity($path);
        $int = Lib_redis::VerificationCode($phone,$code);
        dd($int);


//        $name = '丁建军';
//        $id_card = '510125199506266310';
//        $result = AliCloudService::market($name);
//
        $response_json = $this->initResponse();

        $tmp = '四川';

        $jsontwo = json_decode($json,true);
        if($jsontwo['status'] == 0){
            $data = $jsontwo['data'];
            $tempArr = array_column($data, null, 'province');
            $datas = [];
            foreach($tempArr as $k=>$v){
                if($k == $tmp){
                    $datas[] = $v;
                }
            }
            dd($datas);
            $response_json->status = Lib_const_status::SUCCESS;
            $response_json->data = $jsontwo['result']['list'];
        }elseif($jsontwo['status'] == 210){
            $response_json->status = Lib_const_status::SUCCESS;
        }else{
            $response_json->status = Lib_const_status::SERVICE_ERROR;
        }
        return $this->response($response_json);
//        $name = 'hahahheheheeheh';
//        $id_card = '510125199506266310';
//        $result = AliCloudService::market($name);
//        dd(json_decode($result,true));

        dd(json_decode($json,true));
        $date = date('Y-m-d');
        $company = '企业';
        $sign = '甲方';
        $message = "于{$date}同{$company}拟定的合同{$sign}已签字,发送至您的邮箱。请注意查收,及时回复！";

        dd($message);
        $config = Lib_make::getConfig();
        dd($config);
        $card = '51012519950626631';
        $bool = IdentityService::MatchIdentityInformation($card);
        dd($bool);

        dd(1);
        $content="杰大哥印章";
        $content = mb_convert_encoding($content, "html-entities","utf-8" );
        $pic = public_path()."/images/1.png";
        $t = $this->setTextWater($pic,$content,"255,0,0",4,30);//这个方法见后面

        echo $t;
        dd($t);


//        $user_id = 1;
//        $ids = [2,3,4];
//        $array = Lib_make::getSearchHistory($user_id);
//        $array = Lib_make::HandleSearchHistory($user_id,$ids);
//        dd($array);
//        $config = Lib_make::getConfig();

//        dd($array);
    }

    /**
     * 文字水印
     * @param $imgSrc
     * @param $markText
     * @param $TextColor
     * @param $markPos
     * @param int $fontSize
     * @return bool|string
     */
    function setTextWater($imgSrc,$markText,$TextColor,$markPos,$fontSize = 30)
    {
        $fontType = public_path().'/font/ping.ttf';
        $srcInfo = @getimagesize($imgSrc);
        $srcImg_w    = $srcInfo[0];
        $srcImg_h    = $srcInfo[1];
        $markText = mb_convert_encoding($markText, "html-entities","utf-8" );
        $markedfilename= public_path()."/images/test/".time();

        switch ($srcInfo[2])
        {
            case 1:
                $srcim =imagecreatefromgif($imgSrc);
                $markedfilename.=".gif";
                break;
            case 2:
                $srcim =imagecreatefromjpeg($imgSrc);
                $markedfilename.=".jpg";
                break;
            case 3:
                $srcim =imagecreatefrompng($imgSrc);
                $markedfilename.=".png";
                break;
            default:
                echo "不支持的图片文件类型";
                return false;
        }
        {

            if(!empty($markText))
            {
                if(!file_exists($fontType))
                {
                    echo '字体文件不存在';
                    return false;
                }
            }
            else {
                echo '没有水印文字';
                return false;
            }
            //此函数返回一个含有8个单元的数组表示文本外框的四个角，索引值含义：0代表左下角 X 位置，1代表坐下角 Y 位置，
            //2代表右下角 X 位置，3代表右下角 Y 位置，4代表右上角 X 位置，5代表右上角 Y 位置，6代表左上角 X 位置，7代表左上角 Y 位置
            $box = @imagettfbbox($fontSize, 0, $fontType,$markText);
            //var_dump($box);exit;
            $logow = max($box[2], $box[4]) - min($box[0], $box[6]);
            $logoh = max($box[1], $box[3]) - min($box[5], $box[7]);
        }



        switch($markPos)
        {
            case 1:
                $x = 5;
                $y = $fontSize;
                break;
            case 2:
                $x = ($srcImg_w - $logow) / 2;
                $y = $fontSize;
                break;
            case 3:
                $x = $srcImg_w - $logow - 5;
                $y = $fontSize;
                break;
            case 4:
                $x = $fontSize;
                $y = ($srcImg_h - $logoh) / 2;
                break;
            case 5:
                $x = ($srcImg_w - $logow) / 2;
                $y = ($srcImg_h - $logoh) / 2;
                break;
            case 6:
                $x = $srcImg_w - $logow - 5;
                $y = ($srcImg_h - $logoh) / 2;
                break;
            case 7:
                $x = $fontSize;
                $y = $srcImg_h - $logoh - 5;
                break;
            case 8:
                $x = ($srcImg_w - $logow) / 2;
                $y = $srcImg_h - $logoh - 5;
                break;
            case 9:
                $x = $srcImg_w - $logow - 5;
                $y = $srcImg_h - $logoh -5;
                break;
            default:
                $x = rand ( 0, ($srcImg_w - $logow) );
                $y = rand ( 0, ($srcImg_h - $logoh) );
        }

        $dst_img = @imagecreatetruecolor($srcImg_w, $srcImg_h);

        imagecopy ( $dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h);


        {
            $rgb = explode(',', $TextColor);

            $color = imagecolorallocate($dst_img, intval($rgb[0]), intval($rgb[1]), intval($rgb[2]));
            imagettftext($dst_img, $fontSize, 0, $x, $y, $color, $fontType,$markText);
        }


        switch ($srcInfo[2])
        {
            case 1:
                imagegif($dst_img,$markedfilename);
                break;
            case 2:
                imagejpeg($dst_img,$markedfilename);
                break;
            case 3:
                imagepng($dst_img,$markedfilename);
                break;
            default:
                echo ("不支持的水印图片文件类型");
                return false;
        }

        imagedestroy($dst_img);
        imagedestroy($srcim);

        return $markedfilename;
    }

    /**
     * 图片水印
     * @param $imgSrc
     * @param $markImg
     * @param $markPos
     * @return bool
     */
    function  setImgWater($imgSrc,$markImg,$markPos)
    {
        $srcInfo = @getimagesize($imgSrc);
        $srcImg_w    = $srcInfo[0];
        $srcImg_h    = $srcInfo[1];
        $img_water = "./waterpic";   //生成的图片文件名
        switch ($srcInfo[2])
        {
            case 1:
                $srcim =imagecreatefromgif($imgSrc);
                $img_water.=".gif";
                break;
            case 2:
                $srcim =imagecreatefromjpeg($imgSrc);
                $img_water.=".jpg";
                break;
            case 3:
                $srcim =imagecreatefrompng($imgSrc);
                $img_water.=".png";
                break;
            default:
                echo "不支持的图片文件类型";
                return false;
        }
        {
            if(!file_exists($markImg) || empty($markImg))
            {
                echo '水印文件不存在';
                return false;
            }

            $markImgInfo = @getimagesize($markImg);
            $markImg_w    = $markImgInfo[0];
            $markImg_h    = $markImgInfo[1];

            if($srcImg_w < $markImg_w || $srcImg_h < $markImg_h)
            {
                echo '水印文件比源图片文件都还大';
                return false;
            }

            switch ($markImgInfo[2])
            {
                case 1:
                    $markim =imagecreatefromgif($markImg);
                    break;
                case 2:
                    $markim =imagecreatefromjpeg($markImg);
                    break;
                case 3:
                    $markim =imagecreatefrompng($markImg);
                    break;
                default:
                    echo ("不支持的水印图片文件类型");
                    return false;
            }

            $logow = $markImg_w;
            $logoh = $markImg_h;
        }


        switch($markPos)
        {
            case 1:
                $x = 5;
                $y = 5;
                break;
            case 2:
                $x = ($srcImg_w - $logow) / 2;
                $y = 5;
                break;
            case 3:
                $x = $srcImg_w - $logow - 5;
                $y = 5;
                break;
            case 4:
                $x = 5;
                $y = ($srcImg_h - $logoh) / 2;
                break;
            case 5:
                $x = ($srcImg_w - $logow) / 2;
                $y = ($srcImg_h - $logoh) / 2;
                break;
            case 6:
                $x = $srcImg_w - $logow - 5;
                $y = ($srcImg_h - $logoh) / 2;
                break;
            case 7:
                $x = 5;
                $y = $srcImg_h - $logoh - 5;
                break;
            case 8:
                $x = ($srcImg_w - $logow) / 2;
                $y = $srcImg_h - $logoh - 5;
                break;
            case 9:
                $x = $srcImg_w - $logow - 5;
                $y = $srcImg_h - $logoh -5;
                break;
            default:
                $x = rand ( 0, ($srcImg_w - $logow) );
                $y = rand ( 0, ($srcImg_h - $logoh) );
        }

        $dst_img = @imagecreatetruecolor($srcImg_w, $srcImg_h);

        imagecopy ( $dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h);

        {
            imagecopy($dst_img, $markim, $x, $y, 0, 0, $logow, $logoh);
            imagedestroy($markim);
        }

        switch ($srcInfo[2])
        {
            case 1:
                imagegif($dst_img, $img_water );
                break;
            case 2:
                imagejpeg($dst_img, $img_water );
                break;
            case 3:
                imagepng($dst_img, $img_water );
                break;
            default:
                echo ("不支持的水印图片文件类型");
                return false;
        }

        imagedestroy($dst_img);
        imagedestroy($srcim);

        echo 'success,the watermarked picture is '.$img_water."\n";
        return true;
    }
}