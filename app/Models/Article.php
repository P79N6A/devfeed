<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Fedn\Models\Article
 *
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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('status', '=', 'publish');
        });
    }

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

/*    public function metas() {
        return $this->hasMany(ArticleMeta::class);
    }*/

    public function getIsLinkAttribute() {
        return !empty($this->source_url);
    }

    public function getSourceSite() {
        if(empty($this->source_url)){
            return "本站原创";
        } else {
            $host = parse_url($this->source_url, PHP_URL_HOST);
            return $host ? $host : '网络转载';
        }
    }

}
