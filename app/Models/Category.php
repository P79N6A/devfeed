<?php

namespace Fedn\Models;

use Baum\Node;

/**
 * Fedn\Models\Category
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property integer $pid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class Category extends Node
{
    protected $table = 'categories';

    protected $orderColumn = 'order';

    protected $guarded = ['id', 'parent_id', 'lft', 'rgt', 'depth'];

    public function articles() {
        return $this->morphedByMany(Article::class, 'classifiable');
    }

}
