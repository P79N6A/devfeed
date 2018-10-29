<?php

namespace Fedn\Http\Controllers\api;

use Cache;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Team;
use Illuminate\Http\Request;
use Fedn\Models\Article;

class TeamController extends Controller
{

    public function list(Request $req)
    {

        $page = $req->get('page', null);
        $size = $req->get('size', 10);

        $cacheKey = 'teams_';

        $query = Team::withCount('articles')->orderBy('likes', 'desc')->orderBy('updated_at', 'desc');

        if($page) {
            $page = is_numeric($page) && $page > 0 ? $page : 1;
            $size = is_numeric($size) && $size < 500 ? $size : 10;
            $cacheKey = 'teams_'.$page;
        } else {
            $cacheKey = 'teams_all';
        }

        $cacheExpiration = app()->isLocal() ? 0 : 60;

        $teams = Cache::tags('teams')->remember($cacheKey, $cacheExpiration, function() use ($cacheKey, $query, $page, $size){
            $returnAll = $cacheKey === 'teams_all';

            $data = $returnAll ? $query->get() : $query->paginate($size, ['*'], 'page', $page);

            if($returnAll) {
                $total = $data->count();
                $data = [
                    'total'=>$total,
                    'per_page'=>$size,
                    'current_page'=>1,
                    'next_page_url'=>null,
                    'prev_page_url'=>null,
                    'data' => $data
                ];
            }

            return $data;
        });

        return response()->json($teams);

    }

    public function save(Request $req) {
        $rules = [
            'title' => 'required',
            'logo'  => 'required_without:id|mimes:jpeg,png|dimensions:width=200,height=200',
            'website'   => 'required|url',
            'description' => 'required|max:500'
        ];
        $messages = [
            'title.required' => '团队名称必须填写。',
            'logo.required_without'  => '请提供 200x200 像素的团队 LOGO 图片。',
            'logo.mimes' => '团队 Logo 必须是 jpg 或者 png 格式。',
            'logo.dimensions' => '团队 Logo 的尺寸必须是 200x200 像素。',
            'website.required' => '团队网址必须填写。',
            'website.url' => '团队网址必须是正确的 URL 地址。',
            'description.required' => '团队介绍必须填写（支持 markdown 语法)',
            'description.max' => '团队介绍不能超过 :max 个字符。'
        ];
        $validator = validator($req->all(), $rules, $messages);
        if($validator->fails()) {
            return response()->json(['ret'=>1, 'message' => $validator->getMessageBag()->all()]);
        }

        if($req->has('id') && is_numeric($req->get('id'))) {
            $team = Team::find($req->get('id'));
            if(!$team) {
                return response()->json(['ret' => 404, 'message' => 'Model not found.']);
            }
        } else {
            $team = new Team();
        }

        $team = $team->fill($req->only(['title', 'website', 'description']));

        if($req->hasFile('logo') && $req->file('logo')->isValid()) {
            $upFile = $req->logo;
            $filename = $team->logoFile($upFile->getClientOriginalExtension());
            $upFile->move(Team::LOGO_PATH, $filename);
            $team->logo  = url(Team::LOGO_PATH.'/'.$filename);
        }

        $result = $team->save() ? ['ret' => 0, 'message' => $team] : ['ret' => 2, 'message' => 'Save failed.'];

        if($result) {
            Cache::tags('teams')->flush();
        }
        return response()->json($result);

    }

    public function del(Request $req)
    {
        $id = $req->has('id') ? intval($req->get('id', 0)) : 0;

        if(!$id) {
            return response()->json([
                'ret' => 1,
                'message' => 'parameter must be valid id.'
            ]);
        }

        $count = Team::destroy($id);

        if($count > 0) {
            Cache::tags('teams')->flush();
        }

        return $count > 0 ? response()->json([
            'ret' => 0,
            'message' => 'Success.',
            'data' => $count
        ]) : response()->json([
            'ret' => 404,
            'message' => 'Nothing deleted.',
            'data' => 0
        ]);
    }

    public function detail(Request $req)
    {
        $id = $req->get('id', 1);
        $page = $req->get('page', null);
        $size = $req->get('size', 10);
        $data = null;
        $team = Team::find($id);

        if(!is_numeric($id) || (int)$id != $id) {
            $result = [
                "code" => 40035,
                "message" => 'Invalid parameters.',
                "data" => $data
            ];
            return response()->json($result);
        }

        if(!$team) {
            $result = [
                "code" => 46001,
                "message" => 'Team not found.',
                "data" => $data
            ];
        } else {
            $articleDetail = Article::where('team_id','=',$id)->orderBy('updated_at', 'desc')->paginate($size);
            $articleDetail = $this->setDefaultFigureArticle($articleDetail);
            $team->articles = $articleDetail;
            $result = [
                "code" => 0,
                "message" => '',
                "data" => $team
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
