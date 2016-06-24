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

Route::get('/', function () {
    return view('welcome');
});


/** public */
Route::get('/login/qq', 'Auth\AuthController@loginWithQQ');
Route::get('/auth/qqlogin', 'Auth\AuthController@handleQQLogin');

/** front-end */

/** backend */

Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'as'=>'admin.'], function(){
    Route::get('/', ['as'=>'home', 'uses'=>'AdminController@getIndex']);

    // roles
    Route::get('roles', ['as'=>'roles', 'uses'=>'RoleController@getRoles']);
    Route::get('users', ['as'=>'users', 'uses'=>'UserController@getUsers']);
    Route::post('save-role', ['as'=>'role.save', 'uses'=>'RoleController@postSave']);
    Route::get('del-role/{role}', ['as'=>'role.del', 'uses'=>'RoleController@postDelete'])->where('role', '[0-9]+');

    // categories
    Route::get('categories', ['as'=>'categories', 'uses'=>'CategoryController@getIndex']);

    // articles
    Route::get('articles', ['as'=>'articles', 'uses'=>'ArticleController@getArticles']);

});

Route::group(['prefix'=>'api/v1', 'as'=>'api.'], function(){
    Route::group(['namespace'=>'Admin'],function(){
        Route::get('categories', ['as' => 'category.list', 'uses' => 'CategoryController@listApi']);
        Route::post('categories', ['as' => 'category.save', 'uses' => 'CategoryController@saveApi']);
        Route::delete('categories', ['as' => 'category.delete', 'uses' => 'CategoryController@delApi']);
    });
});

Route::auth();

Route::get('/home', 'HomeController@index');
