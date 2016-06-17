<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Fedn\Models\Article
 *
 * @property integer $id
 * @property integer $userId
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property \Carbon\Carbon $createdAt
 * @property \Carbon\Carbon $updatedAt
 * @property string $deleted_at
 * @property-read \Fedn\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fedn\Models\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fedn\Models\Tag[] $tags
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Article whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Article whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Article whereSummary($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Article whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Article whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    use SoftDeletes;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('Fedn\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() {
        return $this->morphToMany('Fedn\Models\Category', 'classifiable');
    }

    public function tags() {
        return $this->morphToMany('Fedn\Models\Tag', 'taggable');
    }

}
