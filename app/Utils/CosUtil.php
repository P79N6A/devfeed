<?php
/**
 * Created by PhpStorm.
 * User: kaireewu
 * Date: 2018/1/15
 * Time: 22:12
 */

namespace Fedn\Utils;

use Qcloud\Cos\Client as CosClient;

class CosUtil
{

    /**
     * @var \Qcloud\Cos\Client $client
     */
    protected static $client = null;
    protected static $bucket = null;

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
        }
        return static::$client;
    }

    public static function saveToCos($path, $resource)
    {
        $client = static::getClient();

        $client->upload(static::$bucket, $path, $resource);
    }
}
