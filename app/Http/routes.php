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

Route::get('/','HomeController@index');
Route::get('/home', 'HomeController@index');


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

Route::get('update', ['middleware'=>'auth', function(){
    $user = Auth::user();
    if($user->hasRole('Admin')) {
        set_time_limit(300);
        $exitCode = Artisan::call('app:update');
        return $exitCode === 0 ? "OK" : "Failed.";
    } else {
        die('你没有进行此操作的权限！');
    }
}]);

Route::auth();
