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
use GuzzleHttp\Client as GuzzleHttp;

use Fedn\Utils\FednUtil as Tool;
use phpQuery;

class QuotaUtils
{

    protected static $guzzleOption = [
        'timeout' => 10,
        'allow_redirects' => true,
        'verify' => false,
        'defaults' => [
            'headers' => [
                'user-agent' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36',
                'accept' => 'accept:text/html,application/xhtml+xml,application/xml'
            ]
        ]
    ];

    protected static $ua = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36';

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

    public static function resolveUrl($base, $relative) {


        if(substr($relative,0,4) === 'http' || substr($relative,0,2) === '//') {
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
        $options = static::$guzzleOption;
        $options['defaults']['headers']['referer'] = $site->list_url;

        if(getenv('HTTP_PROXY')) {
            $options['proxy'] = getenv('HTTP_PROXY');
        }

        $client = new GuzzleHttp($options);

        $flagExceptions = ['exceptions' => false];

        $res = $client->get($site->list_url, $flagExceptions);

        if ($res->getStatusCode() <= 304) {
            $html = (string)$res->getBody();
            $res = null;


            $pq = phpQuery::newDocumentHTML($html);

            $_links = $pq->find($site->sel_link);

            $links = [];
            foreach($_links as $link) {
                $_url = pq($link)->attr('href');

                $links[] = QuotaUtils::resolveUrl($site->list_url, $_url);
            }

            $pa = null;

            return $links;
        } else {
            return [];
        }

    }

    protected static function fetchArticle($link, Site $site)
    {
        $options = static::$guzzleOption;
        $options['defaults']['headers']['referer'] = $site->list_url;

        if (getenv('HTTP_PROXY')) {
            $options['proxy'] = getenv('HTTP_PROXY');
        }

        $client = new GuzzleHttp($options);
        $flagExceptions = ['exceptions' => false];
        $res = $client->get($link, $flagExceptions);

        if ($res->getStatusCode() <= 400) {
            $html = $res->getBody()->getContents();
            $res = null;

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
}
