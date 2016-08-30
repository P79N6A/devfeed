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
        $articles = Cache::tags(['article','home'])->remember('articles_'.$page, 10, function(){
            return Article::with('tags')->paginate(10);
        });
        return view('home', ['articles'=>$articles]);
    }

    public function redirectToIndex()
    {
        
    }
}
