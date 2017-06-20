<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Article;
use Cache;
use URL;
class ArticleController extends Controller
{
    public function view($id) {
        $newArticle = Cache::tags('articles')->remember('newest_5', 30, function() use ($id) {
            return Article::where('id', '!=', $id)->latest()->take(5)->get();
        });
        //$likeArticle = Article::where('id', '!=', $id)->orderBy(\DB::raw('RAND()'))->take(5)->get();
        $article = Cache::remember('article_'.$id, 30, function() use ($id) {
            return Article::with('tags')->findOrFail($id);
        });

        $likeArticle = Article::whereHas('tags', function($query) use ($article) {
            $query->whereIn('title', $article->tags->pluck('title'));
        })->where('id', '!=', $id)->latest('click_count')->take(5)->get();

        $article->timestamps = false;
        $article->click_count += 1;
        $article->save();

        return view('front.article', ['art'=>$article,'new'=>$newArticle,'like'=>$likeArticle]);
    }

    public function view_v2($id){
        $article = Cache::remember('article_'.$id, 30, function() use ($id) {
            return Article::with('tags')->findOrFail($id);
        });
        $article->timestamps = false;
        $article->click_count += 1;
        $article->save();

        //导航条 navbar
        $referUrl = URL::previous();
        $nav = array(
            'href' =>   $referUrl
        );
        if(strpos($referUrl,'hot',0)){
            $nav['name'] = '最热';
        }else{
            $nav['name'] = '最新';
        }
        return view('v2017.article', ['art'=>$article,
                                      'nav' =>$nav]);
    }
}
