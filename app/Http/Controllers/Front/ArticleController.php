<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Article;

class ArticleController extends Controller
{
    public function view($id) {
        $article = Article::with('tags')->findOrFail($id);

        return view('front.article', ['art'=>$article]);
    }
}
