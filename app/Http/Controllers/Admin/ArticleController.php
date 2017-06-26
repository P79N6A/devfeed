<?php

namespace Fedn\Http\Controllers\Admin;

use Cache;
use Fedn\Http\Controllers\Controller;
use Fedn\Http\Requests\ArticleFormRequest;
use Fedn\Models\Article;
use Fedn\Models\Tag;
use Fedn\Models\Team;
use Fedn\Utils\QuotaUtils;
use Gate;
use HttpInvalidParamException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticleController extends Controller
{
    public function getIndex()
    {
        $articles = Article::withoutGlobalScope('published')->orderBy('status')->orderBy('id','desc')->with(['user', 'tags', 'team'])->paginate(10);
        return view('backend.article-list', compact('articles'));
    }

    public function new()
    {
        if(Gate::denies('create-article')) {
            return response('Unauthorized.', 403);
        }

        $article = new Article;
        $Tags = Tag::all();
        return view('backend.article-form', ['article' => $article,'Tags'=>$Tags]);
    }

    /**
     * @param integer $id Article ID.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     *
     * @throws HttpInvalidParamException
     * @throws ModelNotFoundException
     */
    public function edit(int $id = null) {
        if(is_null($id)) {
            $article = new Article;
        } else if (!is_numeric($id)) {
            throw new HttpInvalidParamException('ID must be an integer.');
        } else {
            $article = Article::withoutGlobalScope('published')->with(['tags'])->find($id);
        }

        if(!$article) {
            throw new ModelNotFoundException('文章不存在！');
        }
        $this->authorize('update', $article);
        $tags = Tag::all();
        $teams = Team::get(['id','title']);
        return view('backend.article-form', ['article'=>$article,'tags'=>$tags, 'teams' => $teams]);
    }

    //文章删除
    public function destroy($id)
    {

        $ar = Article::withoutGlobalScope('published')->find($id);
        if($ar) {
            $ar->delete();
        }
        Cache::tags('articles')->flush();
        if(request()->ajax()) {
            return QuotaUtils::JsonResult($ar);
        }
        return redirect()->back();
    }
    //文章发布
    public function publish($id)
    {
        $result = 0;
        $Ar = Article::withoutGlobalScope('published')->find($id);
        if($Ar){
            $Ar->status = 'publish';
            if($Ar->save()) {
                $result = 1;
            }
        }
        Cache::tags('articles')->flush();
        return json_encode (['data'=> $result]);
    }
    public function save(ArticleFormRequest $request, $id = 0)
    {

        $data = $request->all();
        $article = Article::withoutGlobalScope('published')->findOrNew($id);
        if($article->exists){
            $this->authorize('update', $article);
        } else {
            if (Gate::denies('create-article')) {
                return response('Unauthorized.', 403);
            }
            $article->user_id = request()->user()->id;
        }

        $article->title = $data['title'];
        $article->summary = $data['summary'];
        $article->source_url = $request->get('source_url', '');
        $article->author = $data['author'];
        $article->author_url = $request->get('author_url', '');
        //$article->is_link = !empty($data['source_url']);
        $article->content = $data['content'];
        $article->status = $data['status'];
        $article->team_id = $data['team_id'];


        if ($request->hasFile('figure')) {
            $save_path = '/upload/figure/';
            if (is_dir($save_path)) {
                mkdir($save_path, 0777, true);
            }
            $file = $request->file('figure');
            $ext = $file->getClientOriginalExtension();
            $targetFile = time() . mt_rand(100, 999) . ".$ext";
            $file->move(public_path($save_path), $targetFile);
            $figure = $save_path . $targetFile;
            $article->figure = $figure;
        }

        $article->save();
        Cache::forget('article_'.$article->id);

        if($article->wasRecentlyCreated) {
            Cache::tags('articles')->flush();
        }

        // metas

        // tags
        $tags = $request->get('tags','');
        if($tags) {
            $tags = explode(',', $tags);
        } else {
            $tags = [];
        }
        foreach($tags as $tag) {
            $tag = trim($tag);
            if(empty($tag)) {
                continue;
            }
            Tag::firstOrCreate(['title' => $tag, 'slug' => urlencode($tag)]);
        }
        $tag_ids = Tag::whereIn('title', $tags)->pluck('id')->toArray();
//        计算TAG相关文章数量
//        $tagCount = Tag::findOrFail($tag_ids[0]);
//        $tagCount ->count +=1;
//        $tagCount ->save();

        $article->tags()->sync($tag_ids);

        // categories
        //$article->categories()->sync($data['categories']);

        return redirect('admin/articles')->with('message', ['type' => 'success', 'text' => "文章《$article->title》已保存"]);
    }
}
