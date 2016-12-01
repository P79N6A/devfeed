<?php
/**
 * Filename: QuotaUtils.php
 * @author: kaireewu
 * @copyright: 2012-2016 TGideas
 */

namespace Fedn\Utils;

use Snoopy\Snoopy;
use phpQuery;
use Fedn\Models\Site;
use Fedn\Models\Quota;
use GuzzleHttp\Psr7\Uri;

class QuotaUtils
{

    protected static $guzzleOption = [
        'timeout' => 5,
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

        return $result;
    }

    public static function fetch(site $site, bool $checkExists = true) {

        $links = static::fetchLinks($site);

        $items = [];

        foreach ($links as $link) {
            if($checkExists) {
                $quota = Quota::withTrashed()->firstOrNew(['url' => $link]);
                if ($quota->exists) {
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
        $base = new Uri($base);

        if(substr($relative,0,4) === 'http' || substr($relative,0,2) === '//') {
            return $relative;
        } else {
            return (string)Uri::resolve($base, $relative);
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

        //$client = new GuzzleHttp($options);

        //$flagExceptions = ['exceptions' => false];

        //$res = $client->get($site->list_url, $flagExceptions);


        $res = new Snoopy();
        //$res->proxy_host = 'proxy.tencent.com';
        //$res->proxy_port = '8080';
        $res->agent = static::$ua;
        $res->referer = $site->url;
        $res->accept = 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';

        $res->fetch($site->list_url);

        if ($res->status == 200 || $res->status == 304) {
        //if ($res->getStatusCode() <= 304) {
            //$html = (string)$res->getBody();
            //$res = null;



            $html = $res->getResults();

            $res = null;

            //$crawler = new Crawler($html);

            //$links = $crawler->filter($site->sel_link)->extract('href');

            //$crawler = null;

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
        //$options = static::$guzzleOption;
        //$options['defaults']['headers']['referer'] = $site->list_url;

        //$client = new GuzzleHttp($options);
        //$flagExceptions = ['exceptions' => false];
        //$res = $client->get($link, $flagExceptions);
        $res = new Snoopy();
        //$res->proxy_host = 'proxy.tencent.com';
        //$res->proxy_port = '8080';
        $res->agent = static::$ua;
        $res->referer = $site->url;
        $res->accept = 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
        $res->fetch($link);
        //if ($res->getStatusCode() <= 400) {
            //$html = $res->getBody()->getContents();
        if ($res->status == 200 || $res->status == 304) {
            $html = $res->getResults();

            $doc = phpQuery::newDocumentHTML($html);

            $data = [];
            $data['title'] = trim($doc->find($site->sel_title)->text(), "　 \t\n\r\v");
            $data['url'] = $link;
            $data['content'] = trim($doc->find($site->sel_content)->html(), "　 \t\n\r\v");

            if(substr($site->sel_tag,0,1) === '=') {
                $data['tags'] = substr($site->sel_tag, 1);
            } else if (substr($site->sel_tag, 0, 1) === '-') {
                $data['tags'] = '';
            } else {
                $tags = $doc->find($site->sel_tag)->texts();
                $data['tags'] = implode(',', $tags);
            }

            $data['site_name'] = $site->name;
            $data['site_url'] = $site->url;

            if(substr($site->sel_author_name, 0, 1) === '=') {
                $data['author_name'] = substr($site->sel_author_name, 1);
            } else if (substr($site->sel_author_name, 0, 1) === '-') {
                $data['author_name'] = '';
            } else {
                $data['author_name'] = $doc->find($site->sel_author_name)->text();
            }

            if(substr($site->sel_author_link, 0, 1) === '=') {
                $data['author_url'] = substr($site->sel_author_link, 1);
            } else if (substr($site->sel_author_link, 0, 1) === '-') {
                $data['author_url'] = '';
            } else {
                $author_url = $doc->find($site->sel_author_link)->attr('href');
                $data['author_url'] = QuotaUtils::resolveUrl($link, $author_url);
            }

            $doc = null;

            try {
                $test = response()->json($data);
            } catch ( \Exception $e ) {
                return null;
            }

            return $data;

        } else {
            return null;
        }
    }
}
