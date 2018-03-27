<?php

namespace Fedn\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

use Fedn\Models\Article;
use Fedn\Models\Tag;
use Fedn\Models\Quota;
use Fedn\Models\User;

class DevController extends Controller
{
    public function htmlTest(User $user)
    {
        $url = 'https://www.qianduan.net/tag/html5/';
        $options = ['timeout' => 10, 'allow_redirects' => true, 'verify' => false];
        $client = new Client($options);


        /**
         * \Psr\Http\Message\ResponseInterface
         */
        $res = $client->get($url);

        $html = (string)$res->getBody();

        $dom = new Crawler($html);

        $links = $dom->filter('.read-more')->extract(['href']);
        foreach ($links as $i => $link) {
            $links[$i] = (string)Uri::resolve(new Uri($url), $link);
        }

        dd($links);

        $urls = [];
        foreach ($links as $link) {
            //$urls[] = (string)Uri::resolve(new Uri($url), $link['attributes']['href']);
            $urls[] = $link->attr('href');
        }

        dd($urls);
    }
}
