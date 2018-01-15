<?php
namespace Fedn\Utils;

use Fedn\Models\RemoteFile;
use Iterator;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Illuminate\Support\Facades\Storage;
use Qcloud\Cos\Client;

class ImageUtil
{
    /**
     * @param \Iterator remote image urls $images
     * @param string base url $baseUrl
     *
     * @return \Illuminate\Support\Collection
     */
    public static function fetchImages(Iterator $images, string $baseUrl, $inCos = true)
    {
        $imageFiles = collect([]);
        foreach ($images as $img) {
            $localFile = static::fetchRemote($img, $baseUrl, $inCos);
            if($localFile) {
                $imageFiles->push($localFile);
            }

        }
        return $imageFiles;
    }


    /**
     * Fetch remote file to local
     *
     * @param string | \phpQueryObject $img
     * @param string $baseUrl
     * @param bool $inCos
     * @return \Fedn\Models\RemoteFile | null
     */
    public static function fetchRemote($img, string $baseUrl, $inCos = true)
    {
        $src = is_string($img) ? $img : ($img instanceof \phpQueryObject? $img->getAttribute('src') : '');
        $schema = mb_strtolower(substr($src, 0, 5));
        if ($schema === 'data:') {
            return null;
        }
        if ($schema !== 'http:' && $schema !== 'https') {
            if (starts_with($schema, '//')) {
                $remote = 'http:'.$src;
            } else {
                $remote = (string)UriResolver::resolve(new Uri($baseUrl), new Uri($src));
            }
        } else {
            $remote = $src;
        }

        $file = static::downloadFile($remote, $baseUrl, $inCos);

        return $file;
    }

    public static function downloadFile(string $url, string $baseUrl, $inCos = true)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_BINARYTRANSFER => 1,
            CURLOPT_REFERER => $baseUrl,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36'
        ]);

        $raw = curl_exec($ch);
        curl_close($ch);

        $md5 = md5($raw);

        $file = RemoteFile::firstOrNew(['md5' => $md5]);

        if($file->exists) {
            // direct return if file has existed.
            return $file;
        }

        $file->remote = $url;
        $file->base_url = $baseUrl;
        $ext = static::guessExtensionFromContent($raw);
        // save to local
        $path = 'remote/'.date('Y').'/';
        $filename = str_random(3).'-'.$md5.$ext;
        while(Storage::disk('public')->exists($path.$filename)) {
            $file = str_random(3).'-'.$md5.$ext;
        }

        if(Storage::disk('public')->put($path.$filename, $raw)){
            $file->local = Storage::url($path.$filename);
        };

        if($inCos) {
            // todo: save file to qcloud cos
        }

        return $file;

    }


    /**
     * guess file extension from content
     *
     * @param string $content
     *
     * @return string
     */
    public static function guessExtensionFromContent($content)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($content);

        return static::getExtensionFromMimeType($mimeType);
    }


    /**
     * get extension from mimeType
     *
     * @param $mimeType
     *
     * @return string
     */
    public static function getExtensionFromMimeType($mimeType)
    {
        $mimeType = \strtolower($mimeType);
        $imageTypes = [
            'image/png' => '.png',
            'image/jpeg' => '.jpg',
            'image/gif' => '.gif',
            'image/svg+xml' => '.svg',
            'image/tiff' => '.tif',
            'image/webp' => '.webp',
            'image/bmp' => '.bmp'
        ];

        return array_key_exists($mimeType, $imageTypes) ? $imageTypes[$mimeType] : '';
    }
}
