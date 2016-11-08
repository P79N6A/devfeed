<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;

use Fedn\Http\Controllers\Controller;

use Fedn\Models\Article;
use Cache;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = request()->input('page', 1);
        if(is_numeric($page) == false) {
            $page = 1;
        }
        $articles = Cache::remember('articles_'.$page, 10, function(){
            return Article::orderBy('id', 'desc')->with('tags')->paginate(10);
        });
        return view('front.home', ['articles'=>$articles]);
    }

    public function redirectToIndex()
    {

    }
}
