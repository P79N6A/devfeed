<?php

namespace Fedn\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Article;

class ArticleController extends Controller
{
    public function getIndex()
    {
        $articles = Article::orderBy('id','desc')->with('categories')->with('tags')->paginate(10);

        return view('backend.article', compact('articles'));
    }

    public function getNew()
    {
        $article = new Article();

        return view('backend.article-form', compact('article'));
    }
}
