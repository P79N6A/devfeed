<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** public */
Route::get('/login/qq', 'Auth\LoginController@loginWithQQ');
Route::get('/auth/qqlogin', 'Auth\LoginController@handleQQLogin');
Route::get('/auth/social', 'Auth\LoginController@socialBind');
Route::post('/auth/bind', 'Auth\LoginController@bindAccount');
Route::get('/auth/logout', 'Auth\LoginController@logout');

/** front-end */
Route::group(['namespace' => 'Front', 'as' => 'front.'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/hot', ['as' => 'hot', 'uses' => 'HomeController@hot']);

    Route::group(['as' => 'team.', 'prefix' => 'team'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'TeamController@index']);
        Route::get('/{id}', ['as' => 'detail', 'uses' => 'TeamController@detail']);
    });

    Route::group(['as' => 'article.', 'prefix' => 'article'], function () {
        Route::get('/{id}', ['as' => 'view', 'uses' => 'ArticleController@view']);
    });

    Route::group(['as' => 'tag.', 'prefix' => 'tag'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'TagController@index']);
        Route::get('/{id}', ['as' => 'detail', 'uses' => 'TagController@detail']);
    });

    Route::group(['as' => 'feed.'], function () {
        Route::get('/feeds', ['as' => 'list', 'uses' => 'FeedController@listFeeds']);
        Route::get('/feed/{id}', ['as' => 'view', 'uses' => 'FeedController@view']);
    });


});
/** backend */

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'AdminController@getIndex']);

    // roles
    Route::get('roles', ['as' => 'roles', 'uses' => 'RoleController@getRoles']);
    Route::get('users', ['as' => 'users', 'uses' => 'UserController@getUsers']);
    Route::post('save-role', ['as' => 'role.save', 'uses' => 'RoleController@postSave']);
    Route::get('del-role/{role}', ['as' => 'role.del', 'uses' => 'RoleController@postDelete'])->where('role', '[0-9]+');

    // Users
    Route::get('get-users', ['as' => 'user.list', 'uses' => 'UserController@getUsersApi']);
    Route::post('save-users', ['as' => 'user.save', 'uses' => 'UserController@postSaveUserApi']);

    // articles
    Route::get('articles', ['as' => 'articles', 'uses' => 'ArticleController@getIndex']);
    Route::get('article/{id?}', ['as' => 'article.edit', 'uses' => 'ArticleController@edit'])->where('id', '[0-9]+');
    Route::post('article/{id?}', ['as' => 'article.save', 'uses' => 'ArticleController@save'])->where('id', '[0-9]+');
    Route::delete('article/{id}', ['as' => 'article.delete', 'uses' => 'ArticleController@destroy']);
    Route::post('article/publish/{id}', ['as' => 'article.publish', 'uses' => 'ArticleController@publish']);

    // tags
    Route::get('tags', ['as' => 'tags', 'uses' => 'TagController@listTags']);

    Route::get('quotas', ['as' => 'quotas', 'uses' => 'QuotaController@listQuotas']);

    // sites
    Route::get('sites', ['as' => 'sites', 'uses' => 'QuotaController@sites']);

    // teams
    Route::get( 'team/{any?}', ['as' => 'team', 'uses' => function(){
        return view('backend.team');
    }]);

    //special
    Route::get( 'specials', ['as' => 'special', 'uses' => 'SpecialController@index']);
    Route::get( 'special/{id?}', ['as' => 'special.preview', 'uses' => 'SpecialController@preview']);
    Route::get( 'special/km/{id?}', ['as' => 'special.previewKM', 'uses' => 'SpecialController@previewKM']);
    Route::post( 'special/{id?}', ['as' => 'special.save', 'uses' => 'SpecialController@save']);
//    Route::delete( 'special/{id?}', ['as' => 'special.delete', 'uses' => 'SpecialController@delete']);
    Route::get( 'edit_special/{id?}', ['as' => 'special.edit_special', 'uses' => 'SpecialController@edit']);
    Route::post( 'delete_special', ['as' => 'special.delete_special', 'uses' => 'SpecialController@delete_special']);
    Route::post( 'save_article', ['as' => 'special.save_article', 'uses' => 'SpecialController@save_article']);
    Route::post('send_special',['as' => 'special.send_special', 'uses' => 'MailController@send']);

    Route::view('source/{any?}', 'backend.source');

    Route::get('remote/update', ['as' => 'remote.update', 'uses' => 'ArticleController@updateRemote']);

});

Route::group(['namespace' => 'Admin', 'prefix' => 'api/v1', 'as'=>'api.', 'middleware' => 'admin'], function () {
    Route::post('sites', ['as' => 'site.list', 'uses' => 'QuotaController@sites']);
    Route::post('site', ['as' => 'site.save', 'uses' => 'QuotaController@saveSite']);
    Route::post('site/check', ['as' => 'site.check', 'uses' => 'QuotaController@checkSite']);
    Route::post('site/fetch/{id}', ['as' => 'site.fetch', 'uses' => 'QuotaController@fetchSite']);
    Route::post('site/del/{id}', ['as' => 'site.fetch', 'uses' => 'QuotaController@delSite']);
    Route::post('quotas/publish/{id}', ['as' => 'quota.publish', 'uses' => 'QuotaController@publish']);
    Route::post('quotas/del/{id}', ['as' => 'quota.delete', 'uses' => 'QuotaController@delete']);
});

Route::get('update', [
    'middleware' => 'auth',
    function () {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            set_time_limit(300);
            $exitCode = Artisan::call('app:update');
            return $exitCode === 0 ? "OK" : "Failed.";
        } else {
            die('你没有进行此操作的权限！');
        }
    }
]);

Route::get('/home', function () {
    return redirect('/');
});

Route::auth();

if (App::environment() === 'local') {
    Route::group(['prefix' => 'test'], function () {
        Route::get('html', 'DevController@htmlTest');
    });
}
