<?php
/**
 * Filename: QuotaUtils.php
 * @author: kaireewu
 * @copyright: 2012-2016 TGideas
 */

namespace Fedn\Utils;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;
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
                    return;
                }
            }
            $data = static::fetchArticle($link, $site);
            if ($data) {
                $items[] = $data;
            }
        }

        return [
            'links' => $links,
            'items' => $items
        ];

    }

    /**
     * @param Site $site
     * @return array
     */
    protected static function fetchLinks(Site $site)
    {
        $options = static::$guzzleOption;
        $options['defaults']['headers']['referer'] = $site->list_url;

        $client = new GuzzleHttp($options);

        $flagExceptions = ['exceptions' => false];

        try {
            $res = $client->get($site->list_url, $flagExceptions);

            if ($res->getStatusCode() <= 304) {
                $html = (string)$res->getBody();
                $res = null;

                $crawler = new Crawler($html);

                $links = $crawler->filter($site->sel_link)->extract('href');

                $crawler = null;

                return $links;
            } else {
                return [];
            }
        } catch (Exception $e) {
            throw $e;
        }

    }

    protected static function fetchArticle($link, Site $site)
    {
        $options = static::$guzzleOption;
        $options['defaults']['headers']['referer'] = $site->list_url;

        $client = new GuzzleHttp($options);
        $flagExceptions = ['exceptions' => false];
        $res = $client->get($link, $flagExceptions);
        if ($res->getStatusCode() <= 400) {
            $html = $res->getBody()->getContents();
            $crawler = new Crawler();
            $crawler->addHtmlContent($html);
            $data = [];
            $data['title'] = $crawler->filter($site->sel_title)->text();
            $data['url'] = $link;
            $data['content'] = $crawler->filter($site->sel_content)->html();
            $tags = $crawler->filter($site->sel_tag)->extract('_text');
            $data['tags'] = implode(',', $tags);
            $data['site_name'] = $site->name;
            $data['site_url'] = $site->url;
            $data['author_name'] = $crawler->filter($site->sel_author_name)->text();
            $data['author_url'] = $crawler->filter($site->sel_author_link)->attr('href');
            return $data;
        } else {
            return null;
        }
    }
}
