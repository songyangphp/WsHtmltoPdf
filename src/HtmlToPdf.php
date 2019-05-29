<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-27
 * Time: 9:09
 */
namespace wslibs\pdf;

class HtmlToPdf
{

    protected static $sign;
    protected static $request_url = "http://html2pdf.wszx.cc/";

    public static function setRequestUrl($request_url)
    {
        self::$request_url = $request_url;
    }

    public static function setSign($sign)
    {
        self::$sign = $sign;
    }

    protected static function issetSign()
    {
        if(empty(self::$sign)){
            exit("请设置项目唯一标识[sign]");
        }
    }


    /**
     * 异步生成pdf
     * @param $url
     * @param $notify_url
     * @param string $type
     * @return bool|string
     */
    public static function asynCreatePdf($url, $notify_url, $type = 'base64')
    {
        self::issetSign();

        $data = [
            "url" => urlencode($url),
            "notify_url" => urlencode($notify_url),
            "sign" => self::$sign,
            "creat_type" => $type,
        ];

        return self::curlRequest(self::$request_url.'?app=index@asyn',false,'post',$data);
    }


    /**
     * 同步生成pdf
     * @param $url
     * @param string $type
     * @return bool|string
     */
    public static function syncCreatePdf($url, $type = 'base64')
    {
        self::issetSign();
        $data = [
            "url" => urlencode($url),
            "sign" => self::$sign,
            "creat_type" => $type,
        ];

        return self::curlRequest(self::$request_url.'?app=index@sync',false,'post',$data);
    }


    protected static function curlRequest($url, $https = true, $method = "get", $data = null, $json = false)
    {
        $headers = array(
            "Content-type: application/json;charset='utf-8'",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https === true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if ($method === 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($json) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}