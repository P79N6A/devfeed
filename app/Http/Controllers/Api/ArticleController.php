<?php

namespace Fedn\Http\Controllers\api;

use Cache;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function list(Request $req)
    {
        $page = $req->get('page', 1);
        $size = $req->get('size', 10);
        $hot= $req->get('hot', 0);

        $cacheKey = 'articles';

        if($hot == 1){
            $query = Article::with("team")->orderBy('click_count', 'desc');
            $cacheKey .= '_hot';
        }else{
            $query = Article::with("team")->orderBy('updated_at', 'desc');
            $cacheKey .= '_new';
        }

        $page = is_numeric($page) && $page > 0 ? $page : 1;
        $size = is_numeric($size) && $size < 500 ? $size : 10;
        $cacheKey .= '_'.$page;

        $articles = Cache::tags('articles')->remember($cacheKey, 60, function() use ($query, $page, $size){

            $data = $query->paginate($size, ['*'], 'page', $page);

            return $data;
        });
        $articleDetail = $this->setDefaultFigureArticle($articles);
        return response()->json($articles);

    }

    public function detail(Request $req)
    {

        $id = $req->get('id', 1);
        $data = null;
        $articles = Article::with("team")->find($id);

        if(!is_numeric($id) || (int)$id != $id) {
            $result = [
                "code" => 40035,
                "message" => 'Invalid parameters.',
                "data" => $data
            ];
            return response()->json($result);
        }

        if(!$articles) {
            $result = [
                "code" => 46001,
                "message" => 'Article not found.',
                "data" => $data
            ];
        } else {
            $result = [
                "code" => 0,
                "message" => '',
                "data" => $articles
            ];
        }
        return response()->json($result);
    }


    //设置文章默认缩略图
    private function setDefaultFigureArticle($articles){

        foreach ($articles as $article){
            if(empty($article->figure)) {
                $article->figure = 'https://ossweb-img.qq.com/images/js/devfeed/v2017/ossweb-img/images/default.jpg';
            }

        }
        return $articles;
    }

}
