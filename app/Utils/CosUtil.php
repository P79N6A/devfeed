<?php
/**
 * Created by PhpStorm.
 * User: kaireewu
 * Date: 2018/1/15
 * Time: 22:12
 */

namespace Fedn\Utils;

use Mockery\Exception;
use Qcloud\Cos\Client as CosClient;
use Illuminate\Support\Facades\Log;

class CosUtil
{

    /**
     * @var \Qcloud\Cos\Client $client
     */
    protected static $client = null;
    protected static $bucket = null;
    protected static $cdn_url = null;

    /**
     * @return CosClient
     */
    public static function getClient(){
        if(is_null(static::$client)) {
            $config = config('services.cos');
            static::$client = new CosClient([
                'region' => $config['region'],
                'credentials' => $config['credentials']
            ]);
            static::$bucket = $config['bucket'] . '-' .$config['appId'];
            static::$cdn_url = $config['cdn_url'];
        }
        return static::$client;
    }

    public static function saveToCos($path, $resource, $options = [])
    {
        $client = static::getClient();

        try {
            return $client->upload(static::$bucket, $path, $resource, $options);
        } Catch (\Qcloud\Cos\Exception\ServiceResponseException $e) {
            Log::error((string)$e);
            return null;
        }

    }

    public static function getBucket() {
        if(is_null(static::$bucket)) {
            static::getClient();
        }
        return static::$bucket;
    }

    public static function getInfo($key) {
        $client = static::getClient();

        try {
            return $client->headObject([
                'Bucket'=>static::$bucket,
                'Key' => $key
            ]);
        } catch ( Exception $e) {
            Log::error((string)$e);
            return null;
        }
    }

    public static function getUrl($key) {
        return static::$cdn_url . '/' . $key;
    }
}
