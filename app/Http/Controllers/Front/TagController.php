<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;
use DB;
use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Tag;
use Fedn\Models\Article;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::withCount('articles')->orderBy('articles_count','desc')->paginate(15);
        return view('front.tag', ['tags'=>$tags]);
    }
    public function detail($id){

        $Tags = Tag::find($id);
        if(!$Tags) {
            throw new NotFoundHttpException("Page not found.");
        }
        $allTags = Tag::orderBy(\DB::raw('RAND()'))->take(5)->get();
        $Arts =  $Tags->articles()->paginate(10);
        return view('front.tagDetail', ['Tags'=>$Tags,'nowId'=>$id,'Arts'=>$Arts,'allTags'=>$allTags]);
    }
}
