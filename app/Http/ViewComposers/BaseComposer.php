<?php
/**
 * Created by PhpStorm.
 * User: miyatang
 * Date: 2017/6/19
 * Time: 15:21
 */

namespace Fedn\Http\ViewComposers;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Fedn\Models\Team;

class BaseComposer
{


    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
//        $this->users = $users;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        //侧边栏获取团队的
        $teamList = Cache::remember('allTeam', 60, function() {
            return Team::withCount('articles')->orderBy('articles_count')->take(10)->get();
        });
        $baseInfo = array(
            'title' => config('app.name', 'DevFeed'),
            'teamList' => $teamList,
            //'serverName' => 'http://'.$_SERVER['HTTP_HOST']
        );
        $view->with('baseInfo', $baseInfo);
    }
}
