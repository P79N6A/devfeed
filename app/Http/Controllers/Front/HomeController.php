<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;

use Fedn\Http\Controllers\Controller;

use Fedn\Models\Article;
use Cache;
use Illuminate\Support\Facades\Cookie;

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

        $articles = $this->setPreviewToArticle($articles);
        return view('v2017.home', ['articles'=>$articles,
                                    'listType'=>$this->getListType(),
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
        $articles = $this->setPreviewToArticle($articles);
        return view('v2017.home', ['articles'=>$articles,
                                    'listType'=>$this->getListType(),
                                    'currentPage' => '最热']);
    }

    //设置文章的预览
    private function setPreviewToArticle($articles){
        //标题缓存
        $titleCacheArr = array();
        foreach ($articles as $article){
            //设置预览图为文章的第一张图
            $quato = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
            if(preg_match($quato, $article->content,$arr)){
                $arcPreview = array(
                    'type' => 'img',
                    'src' => $arr[1]
                );
            }else{
                //没有图则随机生成一个字母
                //过滤标题
                $item = $this->filterTitle($article->title);
                $itemLength =  mb_strlen($item,'utf-8');
                $titlePreview = mb_substr( $item, 0, 1,'utf-8');
                if(in_array($titlePreview,$titleCacheArr)){
                    //如果首字母在魂村已经出现过，则随机一个
                    $itemShort = mb_substr( $item, rand(1,$itemLength-1), 1,'utf-8');
                }else{
                    $itemShort =  $titlePreview;
                    array_push($titleCacheArr,$titlePreview);
                }
                $arcPreview = array(
                    'type' => 'text',
                    'src' => $itemShort
                );
            }
            $article -> preview = $arcPreview;
        }
        return $articles;
    }


    //过滤标题，只保留中文 英文
    private function filterTitle($chars,$encoding='utf8'){
//        $pattern =($encoding=='utf8')?'/[\x{4e00}-\x{9fa5}a-zA-Z0-9]/u':'/[\x80-\xFF]/';
        $pattern =($encoding=='utf8')?'/[\x{4e00}-\x{9fa5}a-zA-Z]/u':'/[\x80-\xFF]/';
        preg_match_all($pattern,$chars,$result);
        return join('',$result[0]);
    }

    //获取视图的排列方式
    private function getListType(){
        return isset($_COOKIE["list_type"])?$_COOKIE["list_type"]:'list';
    }

    //测试过滤标题
    function test(){

        $arr = array('?><？》”"我们999',',dedL}{P+_)In ths我们999','我f们!@#$%^&*()+_)(*999','!@#$%^&*()+_)(*我sss们999','我23们999','我de们999','0000我们999');
        $result = array();
        $cacheArr = array();
        foreach ($arr as $item){
            //过滤标题
            $item = $this->filterTitle($item);
            $itemLength =  mb_strlen($item,'utf-8');
            $preview = mb_substr( $item, 0, 1,'utf-8');
            if(in_array($preview,$cacheArr)){
                //如果首字母之前已经出现过，则随机一个
                $itemShort = mb_substr( $item, rand(1,$itemLength-1), 1,'utf-8');
            }else{
                $itemShort =  $preview;
                array_push($cacheArr,$preview);
            }
            $resultItem = array(
                'length' =>$itemLength,
                'short' =>$itemShort
            );
            array_push($result,$resultItem);
        }
        return($result);
    }

    public function redirectToIndex()
    {

    }
}
