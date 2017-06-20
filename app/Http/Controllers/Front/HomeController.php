<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;

use Fedn\Http\Controllers\Controller;

use Fedn\Models\Article;
use Fedn\Models\Tag;
use Fedn\Models\Site;
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
        $articles = Cache::tags('articles')->remember('_page_'.$page, 10, function(){
            return Article::orderBy('id', 'desc')->with('tags')->paginate(10);
        });
        return view('front.home', ['articles'=>$articles]);
    }

    //最新
    public  function index_v2(){
        $page = request()->input('page', 1);
        if(is_numeric($page) == false) {
            $page = 1;
        }
        //获取最新的文章
        $articles = Cache::tags('articles')->remember('_page_'.$page, 10, function(){
            return Article::orderBy('id', 'desc')->paginate(10);
        });
        foreach ($articles as $article){
            //设置预览图为文章的第一张图
            $quato = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
            if(preg_match($quato, $article->content,$arr)){
                $article -> previewImg = $arr[1];
            }else{
                $article -> previewImg = "";
            }
        }
        return view('v2017.home', ['articles'=>$articles,
                                    'currentPage' => '最新']);
    }
    //最热
    public function hot(){
        $page = request()->input('page', 1);
        if(is_numeric($page) == false) {
            $page = 1;
        }
        //获取最热的文章
        $articles = Cache::tags('articles')->remember('_page_'.$page, 10, function(){
            return Article::orderBy('click_count', 'desc')->paginate(10);
        });
        foreach ($articles as $article){
            //设置预览图为文章的第一张图
            $quato = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
            if(preg_match($quato, $article->content,$arr)){
                $article -> previewImg = $arr[1];
            }else{
                $article -> previewImg = "";
            }
        }
        return view('v2017.home', ['articles'=>$articles,
                                    'currentPage' => '最热']);
    }

    public function getListByType($type){
        $page = request()->input('page', 1);
        if(is_numeric($page) == false) {
            $page = 1;
        }
        $articles = array();
        switch ($type){
            case "new" :  $articles = $this->getNewList($page) ;break;
            case "hot" : $articles = $this->getHotList($page) ;break;
            case "personal" : $articles = $this->getPersonalList($page); break;
            case "team" : $articles = $this->getTeamList($page) ;break;
            case "guide" : $articles = $this->getGuideList($page) ;break;
            default : break;
        }

//        $returnList = array();
//        foreach ($articles as $articleItem){
//            $tagList = array();
//            foreach ($articleItem->tags as $tag){
//                $tagItem = array(
//                    'id' => $tag->id,
//                    'title' => $tag->title
//                );
//                array_push($tagList,$tagItem);
//            }
//            $returnItem = array(
//                'id' => $articleItem->id,
//                'title' => $articleItem->title,
//                'content' => mb_substr(strip_tags($articleItem->content), 0, 500),
//                'figure' => $articleItem->figure,
//                'tag' => $tagList,
//                'publishTime' => $articleItem->publishTime,
//                'sourceSite' => $articleItem->sourceSite
//            );
//            array_push($returnList,$returnItem);
//        }
        return response()->json($articles);
    }

    private function getNewList($page){
        //获取最新的文章
        $articles = Cache::tags('articles')->remember('_page_'.$page, 10, function(){
            return Article::orderBy('id', 'desc')->paginate(10);
        });
        foreach ($articles as $article){
            //设置预览图为文章的第一张图
            $quato = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
            if(preg_match($quato, $article->content,$arr)){
                $article -> previewImg = $arr[1];
            }else{
                $article -> previewImg = "";
            }
        }
        return $articles;
    }
    private function getHotList($page){
        //获取最热的文章
        $articles = Cache::tags('articles')->remember('_page_'.$page, 10, function(){
            return Article::orderBy('click_count', 'desc')->paginate(10);
        });
        foreach ($articles as $article){
            //设置预览图为文章的第一张图
            $quato = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
            if(preg_match($quato, $article->content,$arr)){
                $article -> previewImg = $arr[1];
            }else{
                $article -> previewImg = "";
            }
        }
        return $articles;
    }

    private function getPersonalList($id){
        //获取个人的文章

    }

    private function getTeamList(){
        //获取团队的文章

    }


    private function getGuideList(){
        //人物
        $sites = Site::paginate(4);
        //标签
        $tags = Tag::withCount('articles')->orderBy('articles_count','desc')->paginate(8);
        $returnData = array(
            "tags" => $tags ,
            "sites" => $sites
        );
        return $returnData;
    }


    public function getListDetailByType($type,$id){
        $page = request()->input('page', 1);
        if(is_numeric($page) == false) {
            $page = 1;
        }
        switch ($type){
            case "personal" : $articles = $this->getPersonalDetail($id); break;
            case "team" : $articles = $this->getTeamDetail($page) ;break;
            default : break;
        }
        return response()->json($articles);
    }
    private function getPersonalDetail($id){

    }

    private function getTeamDetail($id){

    }

    public function redirectToIndex()
    {

    }
}
