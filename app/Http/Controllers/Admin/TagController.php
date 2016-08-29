<?php

namespace Fedn\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Tag;

class TagController extends Controller
{
    public function list()
    {
        $tags = Tag::withCount('articles')->orderBy('updated_at')->paginate(10);

        return view('backend.tag-list', ['tags'=>$tags]);

    }
}
