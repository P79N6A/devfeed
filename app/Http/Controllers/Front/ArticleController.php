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
    public function view($id){
        $article = Cache::tags('articles')->remember('article_'.$id, 30, function() use ($id) {
            return Article::with(['tags','team'])->findOrFail($id);
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
