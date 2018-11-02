<?php

namespace Fedn\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Fedn\Http\Requests\SpecialFormRequest;
use Fedn\Http\Controllers\Controller;

use Illuminate\Support\Facades\View;

use Fedn\Models\Special;
use Fedn\Models\Article;

use Illuminate\Database\Eloquent\ModelNotFoundException;


class SpecialController extends Controller
{
    public function index(){

        $topics = Special::orderBy('id','desc')->paginate(10);
        return view('backend.special',['topics'=>$topics]);
    }

    public function edit(int $id = null){
        $articleDisable = true;
        if(is_null($id)) {
            $special = new Special;
        } else if (!is_numeric($id)) {
            throw new HttpInvalidParamException('ID must be an integer.');
        } else {
            $articleDisable = false;
            $special = Special::withoutGlobalScope('published')->find($id);
        }

        if(!$special) {
            throw new ModelNotFoundException('专题不存在！');
        }
//        $this->authorize('update', $special);
//        $tags = Tag::all();
//        $teams = Team::get(['id','title']);

        //文章列表
        $articles = Article::orderBy('id','desc')->with(['user', 'tags', 'team'])->paginate(20);

        return view('backend.special-form', ['special'=>$special,'articles'=>$articles,'articleDisable'=>$articleDisable]);
    }

    //预览专题
    public function preview(int $id = null){
        if(is_null($id)) {
            $special = new Special;
        } else if (!is_numeric($id)) {
            throw new HttpInvalidParamException('ID must be an integer.');
        } else {
            $special = Special::withoutGlobalScope('published')->find($id);
        }

        if(!$special) {
            throw new ModelNotFoundException('专题不存在！');
        }
        //获取专题的文章

        $articles = Article::find(explode(',',$special->article_list));
        return view('emails.special-preview', ['special'=>$special,'articles'=>$articles]);
    }
    //预览专题
    public function previewKM(int $id = null){
        if(is_null($id)) {
            $special = new Special;
        } else if (!is_numeric($id)) {
            throw new HttpInvalidParamException('ID must be an integer.');
        } else {
            $special = Special::withoutGlobalScope('published')->find($id);
        }

        if(!$special) {
            throw new ModelNotFoundException('专题不存在！');
        }
        //获取专题的文章

        $articles = Article::find(explode(',',$special->article_list));
        return view('emails.special-previewKM', ['special'=>$special,'articles'=>$articles]);
    }

    //保存专题
    public function save(SpecialFormRequest $request, $id = 0){
        $data = $request->all();
        $special = Special::findOrNew($id);
//        if($special->exists){
//            $this->authorize('update', $article);
//        } else {
            //用户授权可优化
//            if (Gate::denies('create-article')) {
//                return response('Unauthorized.', 403);
//            }
//        }
        $special->user_id = request()->user()->id;
        $special->title = $data['title'];
        $special->desc = $data['desc'];
        $special->accept_email = $data['accept_email'];
        $special->send_time = '2017-05-12';
        $special->flag_send = 0;
        $special->save();
        if($id){
            return redirect('admin/specials')->with('message', ['type' => 'success', 'text' => "文章《$special->title》已保存"]);
        }else{
            return redirect('admin/edit_special/'.$special->id)->with('message', ['type' => 'success', 'text' => "文章《$special->title》已保存"]);
        }
    }

    //保存文章id到专题
    public function save_article(Request $request){

        $data = $request->all();
        $special = Special::findOrNew($data['id']);
        $article_id = $data['article_id'];
        if($special->article_list){
            $article_list = explode(',',$special->article_list);
        }else{
            $article_list = array();
        }

        if($data['type'] == 'add'){
            //新增
            array_push($article_list,$article_id);
            //防止重复ID
            $article_list = array_unique($article_list);
        }else{
            //删除
            $offset=array_search($article_id,$article_list);

            if($offset >= 0){
               array_splice($article_list,$offset,1);
            }
        }
        $special->article_list = implode(',',$article_list);
        $special->save();
        return array(
            'article_list' => implode(',',$article_list),
            'id' =>  $special->id
        );
    }
    public  function delete_special(Request $request){
        $data = $request->all();
        $sId = $data['id'];
        $special = Special::findOrNew($sId)->delete();
        return array(
            'id' =>  $sId
        );
    }
}
