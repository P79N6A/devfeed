<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;
use DB;
use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Tag;
use Fedn\Models\Article;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::paginate(15);
        return view('front.tag', ['tags'=>$tags]);
    }
    public function detail($id){
        $allTags = Tag::orderBy(\DB::raw('RAND()'))->take(5)->get();
        $Tags = Tag::find($id);
        $Arts =  $Tags->articles()->paginate(10);
        return view('front.tagDetail', ['Tags'=>$Tags,'nowID'=>$id,'Arts'=>$Arts,'allTags'=>$allTags]);
    }
}
