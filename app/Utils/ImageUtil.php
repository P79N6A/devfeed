<?php
namespace Fedn\Utils;

use Iterator;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;

class ImageUtil
{
    /**
     * @param \Iterator remote image urls $images
     * @param string base url $baseUrl
     * @return array
     */
    public static function fetchImages(Iterator $images, string $baseUrl)
    {
        $imageUrls = [];
        foreach ($images as $img) {
            $src = is_string($img) ? $img : $img->getAttribute('src');
            $remote = '';
            $local = '';
            $schema = \mb_strtolower(substr($src, 0, 5));
            if ($schema === 'data:') {
                continue;
            } elseif ($schema !== 'http:' && $schema !== 'https') {
                if (\starts_with($schema, '//')) {
                    $remote = 'http:'.$src;
                } else {
                    $base = new Uri($baseUrl);
                    $rel = new Uri($src);
                    $remote = (string)UriResolver::resolve($base, $rel);
                }
            } else {
                $remote = $src;
            }
            $imageUrls[$src] = [
                'remote' => $remote,
                'local' => '' // TODO fetch remote image
            ];
        }
        return $imageUrls;
    }
}
