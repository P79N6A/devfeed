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

        $cacheKey = 'articles_';

        if($hot == 1){
            $query = Article::orderBy('click_count', 'desc');
        }else{
            $query = Article::orderBy('updated_at', 'desc');
        }

        if($size == 0) {
            $cacheKey = 'articles_all';
        } else {
            $page = is_numeric($page) && $page > 0 ? $page : 1;
            $size = is_numeric($size) && $size < 500 ? $size : 10;
            $cacheKey = 'articles_'.$page;
        }

        $cacheExpiration = app()->isLocal() ? 0 : 60;

        $teams = Cache::tags('articles')->remember($cacheKey, $cacheExpiration, function() use ($cacheKey, $query, $page, $size){
            $returnAll = $cacheKey === 'articles_all';

            $data = $returnAll ? $query->get() : $query->paginate($size, ['*'], 'page', $page);

            if($returnAll) {
                $total = $data->count();
                $data = [
                    'total'=>$total,
                    'per_page'=>$total,
                    'last_page'=>1,
                    'next_page_url'=>null,
                    'prev_page_url'=>null,
                    'to'=>$total,
                    'data' => $data
                ];
            }

            return $data;
        });

        return response()->json($teams);

    }

    public function detail(Request $req)
    {

        $id = $req->get('id', 1);
        $data = null;
        $articles = Article::find($id);

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
}
