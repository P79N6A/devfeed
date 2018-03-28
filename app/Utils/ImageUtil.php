<?php
namespace Fedn\Utils;

use Fedn\Models\RemoteFile;
use IteratorAggregate;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Mockery\Exception;
use Storage;

class ImageUtil
{
    /**
     * @param \Iterator remote image urls $images
     * @param string base url $baseUrl
     * @param boolean|null whether storage images in cos or not $inCos
     *
     * @return \Illuminate\Support\Collection
     */
    public static function fetchImages(IteratorAggregate $images, string $baseUrl, $inCos = null)
    {
        $inCos = is_null($inCos) ? config('services.cos.enabled') : $inCos;

        $imageFiles = collect([]);
        if(starts_with($baseUrl, '//')) {
            $baseUrl = 'https:'.$baseUrl;
        }
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
                $remote = 'https:'.$src;
            } else {
                $remote = (string)UriResolver::resolve(new Uri($baseUrl), new Uri($src));
            }
        } else {
            $remote = $src;
        }

        $file = static::downloadFile($remote, $baseUrl, $inCos);
        if($file) {
            $file->origin = $src;
            $file->save();
            return $file;
        } else {
            return null;
        }

    }

    public static function downloadFile(string $url, string $baseUrl, $inCos = true)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_REFERER => $baseUrl,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HTTPHEADER => [
                'Accept' => 'image/webp,image/apng,image/*,*/*;q=0.8',
            ],
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_TIMEOUT => 180,
            //CURLOPT_DEFAULT_PROTOCOL => 'https',
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36'
        ]);

        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status < 400 && empty($raw) === false) {
            $md5 = md5($raw);


            $file = RemoteFile::firstOrNew(['md5' => $md5]);

            if ($file->exists) {
                // direct return if file has existed.
                return $file;
            }

            $contentMd5 = base64_encode(md5($raw, true));
            $file->remote = $url;
            $file->base_url = $baseUrl;
            $ext = '';
            try {
                $ext = pathinfo(parse_url($url)['path'], PATHINFO_EXTENSION);

            } catch (Exception $e) {}
            $ext = empty($ext)? static::guessExtensionFromContent($raw) : ".$ext";
            // save to local
            $path = 'remote/'.date('Y').'/';
            $filename = substr($md5, 0, 3).'-'.$md5.$ext;
            $key = $path.$filename;

            if ($inCos) {
                $result = CosUtil::saveToCos($key, $raw, [
                    'ContentMD5'         => $contentMd5,
                    'ContentDisposition' => $filename
                ]);
                if ($result) {
                    $file->local = CosUtil::getUrl($key);
                };
            } else {
                if (Storage::disk('public')->put($key, $raw)) {
                    $file->local = Storage::url($key);
                };
            }
            return $file;
        } else {
            return null;
        }
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
        $mimeType = static::guessMimeTypeFromContent($content);

        return $mimeType ? static::getExtensionFromMimeType($mimeType) : '.unknown';
    }


    /**
     * @param $content
     *
     * @return string a textual description of the <i>string</i>
     * argument, or <b>FALSE</b> if an error occurred.
     */
    public static function guessMimeTypeFromContent($content)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);

        return $finfo->buffer($content);

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
