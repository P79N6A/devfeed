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
 * @mixin \Eloquent
 */
class Article extends Model
{
    use SoftDeletes;

    protected $attributes = [
        'status' => 'draft'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() {
        return $this->morphToMany(Category::class, 'classifiable');
    }

    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function metas() {
        return $this->hasMany(ArticleMeta::class);
    }

    public function getIsLinkAttribute() {
        return !empty($this->source_url);
    }

}
