<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use Fedn\Models\Article;
use Fedn\Models\Quote;
use Fedn\Models\Tag;
use Fedn\Models\Category;
use Illuminate\Foundation\Inspiring;

Route::get('/', function () {
    $tag = new Tag();
    $tag->title = "JavaScript";
    $tag->slug = 'tag-js';
    $tag->save();

    $category = new Category();
    $category->title = 'JavaScript';
    $category->slug = 'cate-js';
    $category->pid = 0;
    $category->save();


    $user = new \Fedn\Models\User();
    $user->email = 'kairee@qq.com';
    $user->name = 'kairee';
    $user->save();

    $article = new Article();
    $article->title = "Test Article";
    $article->summary = Inspiring::quote();
    $article->content = Inspiring::quote();
    $article->save();
    
    $user->push();

    $user->articles()->save($article);

    $article->categories()->save($category);
    $article->tags()->save($tag);


    dd($article);
});
