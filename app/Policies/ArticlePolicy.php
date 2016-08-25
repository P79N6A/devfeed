<?php

namespace Fedn\Policies;

use Fedn\Models\Article;
use Fedn\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user, $ability) {
        if($user->inRoles([1, 2, 3])) {
            return true;
        }
    }

    public function add(User $user)
    {
        return $user->inRoles([1, 2, 3, 4]);
    }

    public function update(User $user, Article $article)
    {
        // 管理者可以更新
        if ($user->inRoles([1,2,3])) {
            return true;
        }

        // 文章作者可以更新
        if ($user->hasRole(4) && $article->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
