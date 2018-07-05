<?php
/**
 * Filename: QuotaUtils.php
 * @author: kaireewu
 * @copyright: 2012-2016 TGideas
 */

namespace Fedn\Utils;

use GuzzleHttp\Psr7\UriResolver;
use Fedn\Models\Site;
use Fedn\Models\Quota;
use GuzzleHttp\Psr7\Uri;

use Fedn\Utils\FednUtil as Tool;
use phpQuery;

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

        return response()->json($result);
    }


    /**
     * @param \Fedn\Models\Site $site
     * @param bool $checkExists
     *
     * @return array
     */
    public static function fetch(site $site, bool $checkExists = true) {

        $links = static::fetchLinks($site);

        $items = [];

        foreach ($links as $link) {
            if($checkExists) {
                $quota = Quota::withTrashed()->where('url','=',$link)->first();
                if ($quota) {
                    continue;
                }
            }
            $data = static::fetchArticle($link, $site);
            if(!is_null($data)) {
                $items[] = $data;
            }
        }

        return [
            'links' => $links,
            'items' => $items
        ];

    }


    /**
     * @param string $base
     * @param string $relative
     *
     * @return string
     */
    public static function resolveUrl($base, $relative) {


        if(substr($relative,0,4) === 'http') {
            return $relative;
        } else {
            $base = new Uri($base);
            $relative = new Uri($relative);
            $uriInterface = UriResolver::resolve($base, $relative);
            return (string)$uriInterface;
        }
    }



    /**
     * @param Site $site
     * @return array
     */
    protected static function fetchLinks(Site $site)
    {


        $html = static::getHtml($site->list_url);


        if ($html) {

            $pq = phpQuery::newDocumentHTML($html);

            $_links = $pq->find($site->sel_link);

            $links = [];
            foreach($_links as $link) {
                $_url = pq($link)->attr('href');

                $links[] = QuotaUtils::resolveUrl($site->list_url, $_url);
            }

            $pa = null;

            return array_reverse($links);
        } else {
            return [];
        }

    }


    /**
     * @param string $link
     * @param \Fedn\Models\Site $site
     *
     * @return array|null
     */
    protected static function fetchArticle($link, Site $site)
    {
        $html = static::getHtml($link);

        if ($html) {

            $doc = phpQuery::newDocumentHTML($html);

            $data = [];
            $data['title'] = trim($doc->find($site->sel_title)->text());
            $data['url'] = $link;
            $data['team_id'] = $site->team_id;
            $data['content'] = trim($doc->find($site->sel_content)->html());

            if(Tool::startsWith($site->sel_tag, "=")) {
                $data['tags'] = substr($site->sel_tag, 1);
            } else if (Tool::startsWith($site->sel_tag, "-")) {
                $data['tags'] = '';
            } else {
                $tags = $doc->find($site->sel_tag)->texts();
                $data['tags'] = implode(',', $tags);
            }

            //todo: auto generate tags from content.

            $data['site_name'] = $site->name;
            $data['site_url'] = $site->url;

            if(Tool::startsWith($site->sel_author_name, "=")) {
                $data['author_name'] = substr($site->sel_author_name, 1);
            } else if (Tool::startsWith($site->sel_author_name, "-")) {
                $data['author_name'] = '';
            } else {
                $data['author_name'] = trim($doc->find($site->sel_author_name)->text());
            }

            if(Tool::startsWith($site->sel_author_link, "=")) {
                $data['author_url'] = substr($site->sel_author_link, 1);
            } else if (Tool::startsWith($site->sel_author_link, "-")) {
                $data['author_url'] = '';
            } else {
                $author_url = $doc->find($site->sel_author_link)->attr('href');
                $data['author_url'] = QuotaUtils::resolveUrl($link, $author_url);
            }

            $doc = null;

            return $data;

        } else {
            return null;
        }
    }


    /**
     * @param string $url
     *
     * @return string
     */
    public static function getHtml($url) {
        $parts = parse_url($url);
        if($parts === false) {
            throw new \InvalidArgumentException("Unable to parse URI: $url");
        }
        if($parts["scheme"] === NULL || $parts["host"] === NULL) {
            throw new \InvalidArgumentException("URI: $url must be a valid url.");
        }

        $postData = json_encode([
            'url' => $url,
            'options' => [
                "loadImages" => false,
                "loadMedias" => false,
                "logRequests" => false,
                "logConsole" => false,
                "logHtml" => true,
                "followRedirect" => true,
                "device" => "default",
                "media" => "screen",
            ]
        ]);

        $ch = curl_init("http://api.webdn.net/api/crawler");
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Accept:application/json', 'Content-Length:'.strlen($postData)]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        try {
            $result = curl_exec($ch);
            $err = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if($err) {
                \Log::error($err);
                return "";
            }

            if($httpCode >= 200 && $httpCode < 300 && empty($result) === false) {
                $result = json_decode($result, true);

                return $result['html'] ?: '';

            } else {
                return "";
            }

        } catch (Exception $e) {
            \Log::error($e);
            return "";
        }
    }
}
