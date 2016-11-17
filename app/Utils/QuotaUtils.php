<?php
/**
 * Filename: QuotaUtils.php
 * @author: kaireewu
 * @copyright: 2012-2016 TGideas
 */

namespace Fedn\Utils;


use GuzzleHttp\Psr7\Uri;

class QuotaUtils
{

    /**
     * @param mixed $data
     * @param int $code
     * @param string $message
     *
     * @return string
     */
    public static function JsonResult($data, $code = 0, $message = 'SUCCESS') {
        $result = [
            "code" => $code,
            "message" => $message,
            "data" => $data
        ];

        return $result;
    }


}