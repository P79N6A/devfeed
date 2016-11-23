<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Article;
use Cache;
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
}
