<?php

namespace Fedn\Http\Controllers\Front;

use Fedn\Models\Article;
use Illuminate\Http\Request;
use Fedn\Http\Controllers\Controller;

class FrontController extends Controller
{

    protected $data = [];

    public function __construct()
    {
        $this->data['title'] = '';
        $this->data['description'] = 'DevFeed（前端开发聚合），聚合前端开发业界最新、最热门、最有价值的文章';
        $this->data['keywords'] = '';
    }

    public function home()
    {
        $this->setTitle('网站首页');
        $articles = Article::orderByDesc('id');

        $result = $articles->paginate(10);

        $this->data['articles'] = $result;

        return view('spider.home', $this->data);
    }

    public function hot($page = 1) {
        $this->setTitle('热门文章');
        $articles = Article::orderByDesc('id');

        $result = $articles->paginate(10, ['*'], 'page', $page);

        $this->data['articles'] = $result;

        return view('spider.hot-and-new', $this->data);
    }

    public function new($page = 1) {

    }

    public function teams($page = 1) {

    }

    public function team($id) {

    }

    public function article($id) {

    }

    protected function setTitle($title)
    {
        $this->data['title'] = $title;
    }

    protected function setDescription($desc)
    {
        $this->data['description'] = $desc;
    }

    protected function setKeywords($keywords)
    {
        if(is_array($keywords)) {
            $this->data['keywords'] = implode(',', $keywords);
        } else {
            $this->data['keywords'] = $keywords;
        }
    }
}
