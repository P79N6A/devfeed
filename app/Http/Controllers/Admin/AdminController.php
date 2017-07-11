<?php

namespace Fedn\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Fedn\Http\Controllers\Controller;

use Illuminate\Support\Facades\View;

use Fedn\Models\Article;
use Fedn\Models\Quota;

class AdminController extends Controller
{
    public function getIndex(){

        $articleCount = Article::count('id');
        $quotaCount = Quota::count('id');
        $path = View::getFinder()->find('backend.home');
        return view('backend.home', ['viewPath'=> $path, 'aCount' => $articleCount, 'qCount' => $quotaCount]);
    }
}
