<?php

namespace Fedn\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

use Fedn\Http\Requests;

use SimplePie;

use Fedn\Models\Article;
use Fedn\Models\Tag;
use Carbon\Carbon;

class DevController extends Controller
{

    public function test() {
        $url = "http://taobaofed.org/atom.xml";

        $feed = new SimplePie();

        $feed->set_feed_url($url);

        $feed->set_cache_location(app()->storagePath().DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'cache');

        $proxy = getenv('HTTP_PROXY');
        if($proxy) {
            $feed->set_curl_options([
                CURLOPT_PROXY => $proxy
            ]);
        }


        $feed->init();

        //$feed->handle_content_type();
        $data = [];
        Article::unguard();
        foreach($feed->get_items() as $item) {
            $title = $item->get_title();
            $link = $item->get_permalink();
            $now = Carbon::now()->toDateTimeString();
            $exist = Article::withoutGlobalScope('published')->where('title', $title)->orWhere('source_url', $link)->first();
            if(!$exist) {
                $art = [];
                $art['title'] = $title;
                $art['source_url'] = $link;
                $art['figure'] = $item->get_thumbnail() ? $item->get_thumbnail()[0] : null;
                $art['summary'] = $item->get_description(true);
                $art['content'] = $item->get_content(false);
                $author = $item->get_author();
                if($author) {
                    $art['author'] = $author->get_name();
                    $art['author_url'] = $author->get_link();
                }
                //$art['enclosure'] = $item->get_enclosure();
                $art['created_at'] = $now;
                $art['updated_at'] = $now;
                $art['status'] = 'publish';

                $model = Article::create($art);

                $tags = $item->get_categories();
                $tag_ids = [];
                if ($tags) {
                    $art['tags'] = [];
                    foreach ($tags as $tag) {
                        $_tag = Tag::firstOrCreate([
                            'title' => $tag->get_label(),
                            'slug' => $tag->get_term()
                        ]);
                        $tag_ids[] = $_tag->id;
                    }
                }
                $model->tags()->sync($tag_ids);

                $model->categories()->sync([1]);

                $data[] = $model;

            }
        }
        Article::reguard();
        dd($data);
    }
}
