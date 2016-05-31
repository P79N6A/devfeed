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
    try {
        $exitCode = Artisan::call('migrate:status');
        $result = Artisan::output();
        return '<pre><code>'.$result.'</code></pre>';
    } catch (RuntimeException $e) {
        dd($e->getMessage());
    }
});

Route::get('/login/qq', 'Auth\AuthController@loginWithQQ');
Route::get('/auth/qqlogin', 'Auth\AuthController@handleQQLogin');
