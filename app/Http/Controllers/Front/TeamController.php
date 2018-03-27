<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Team;
use Fedn\Models\Article;

class TeamController extends Controller
{
    public function index(){
        $page = request()->input('page', 1);
        if(is_numeric($page) == false) {
            $page = 1;
        }
        $teamList = Team::withCount('articles')->paginate(10);
        return view('v2017.teamlist',['currentPage' => '团队','teamList'=>$teamList]);

    }

    public function detail($id){
        $page = request()->input('page', 1);
        if(is_numeric($page) == false) {
            $page = 1;
        }
        $teamDetail = Team::find($id);
        $articleDetail = Article::where('team_id','=',$id)->orderBy('id','desc')->paginate(10);
        $articleDetail = $this->setPreviewToArticle($articleDetail);
        return view('v2017.team',['currentPage' => '团队',
                                  'teamDetail'=>$teamDetail,
                                  'articleDetail'=>$articleDetail]);
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
                    //如果首字母在标题缓存已经出现过，则随机一个，降低文章预览文案相同的概率
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

}
