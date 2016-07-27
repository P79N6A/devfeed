<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Fedn\Models\Tag
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property integer $count
 * @property \Carbon\Carbon $createdAt
 * @property \Carbon\Carbon $updatedAt
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Tag whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Tag whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Tag whereCount($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    protected $guarded = ['id'];
    public function articles() {
        return $this->morphedByMany('Fedn\Models\Article', 'taggable');
    }
}
