<?php

namespace Fedn\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Http\Request;


use Fedn\Models\Article;
use Fedn\Models\Tag;
use Carbon\Carbon;
use Fedn\Models\Quota;

use Symfony\Component\DomCrawler\Crawler;

class DevController extends Controller
{



    public function htmlTest() {
        $url = 'https://fedn.it/';
        $options = ['timeout' => 10,'allow_redirects' => true, 'verify' => false];
        $client = new Client($options);

        /**
         * \Psr\Http\Message\ResponseInterface
         */
        $res = $client->get($url);

        $html = (string)$res->getBody();

        $dom = new Crawler($html);

        $links = $dom->filter('.ac-title a:first-child')->extract(['_text', 'href']);
        dd($links);

        $urls = [];
        foreach($links as $link) {
            //$urls[] = (string)Uri::resolve(new Uri($url), $link['attributes']['href']);
            $urls[] = $link->attr('href');
        }

        dd($urls);

    }
}
