<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });


    Route::group(['namespace' => 'Common'], function () {
        Route::post('upload/{type}', ['as' => 'upload', 'uses' => 'FileController@upload'])
            ->where('type', '(cover|pic)');
    });

    Route::group(['namespace' => 'Api'], function () {
        Route::post('quotas/list', ['as' => 'quota.list', 'uses' => 'QuotaController@list']);
        Route::get('quotas/sites', ['as' => 'quota.sites', 'uses' => 'QuotaController@sites']);
        Route::get('quotas/tags', ['as' => 'quota.tags', 'uses' => 'QuotaController@tags']);
        Route::get('quotas/detail', ['as' => 'quota.detail', 'uses' => 'QuotaController@detail']);
        Route::get( 'teams/list', ['as' => 'teams.list', 'uses' => 'TeamController@list']);
        Route::post('teams/save', ['as' => 'teams.save', 'uses' => 'TeamController@save']);
        Route::post('teams/del', ['as' => 'teams.save', 'uses' => 'TeamController@del']);
    });
});

Route::group(['prefix' => 'v2', 'as' => 'api_v2.'], function () {

    Route::group(['namespace' => 'Api'], function () {
        //文章相关
        Route::get('articles/list', ['as' => 'article/list', 'uses' => 'ArticleController@list']);
        Route::get('article/detail', ['as' => 'article/detail', 'uses' => 'ArticleController@detail']);


        //团队相关
        Route::get('teams/list', ['as' => 'teams/list', 'uses' => 'TeamController@list']);
        Route::get('team/detail', ['as' => 'team/detail', 'uses' => 'TeamController@detail']);
    });
});
