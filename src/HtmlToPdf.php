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

    public static function setSign($sign)
    {
        self::$sign = $sign;
    }


    /**
     * 异步生成pdf
     * @param $url
     * @param $notify_url
     * @param string $type
     * @return bool|string
     */
    public static function asynCreatePdf($url, $notify_url, $type = 'BASE64')
    {
        $url = urlencode($url);
        $data = [
            "url" => $url,
            "notify_url" => $notify_url,
            "sign" => self::$sign,
            "type" => $type,
        ];

        return self::curlRequest('http://html2pdf.wszx.cc/?app=index@asyn',false,'post',$data);
    }


    /**
     * 同步生成pdf
     * @param $url
     * @param $file_id
     * @param string $type
     * @return bool|string
     */
    public static function syncCreatePdf($url, $file_id, $type = 'BASE64')
    {
        $url = urlencode($url);
        $data = [
            "url" => $url,
            "file_id" => $file_id,
            "sign" => self::$sign,
            "type" => $type,
        ];

        return self::curlRequest('http://html2pdf.wszx.cc/?app=index@sync',false,'post',$data);
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