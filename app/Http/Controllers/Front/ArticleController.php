<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Article;

class ArticleController extends Controller
{
    public function view($id) {
        $newArticle = Article::where('id', '!=', $id)->orderBy('created_at')->take(5)->get();
        $likeArticle = Article::where('id', '!=', $id)->orderBy(\DB::raw('RAND()'))->take(5)->get();
        $article = Article::with('tags')->findOrFail($id);
        $article->click_count += 1;
        $article->save();

        return view('front.article', ['art'=>$article,'new'=>$newArticle,'like'=>$likeArticle]);
    }
}
