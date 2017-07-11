<?php
/**
 * Created by PhpStorm.
 * User: miyatang
 * Date: 2017/6/19
 * Time: 15:21
 */

namespace Fedn\Http\ViewComposers;

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
        $teamList = Team::take(5)->get();
        $baseInfo = array(
            'title' => 'FEDN.it',
            'teamList' => $teamList,
            //'serverName' => 'http://'.$_SERVER['HTTP_HOST']
        );
        $view->with('baseInfo', $baseInfo);
    }
}
