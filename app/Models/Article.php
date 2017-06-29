<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

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

    protected $guarded = ['click_count', 'likes', 'dislikes', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['deleted_at'];

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

    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function metas() {
        return $this->hasMany(ArticleMeta::class);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function getIsLinkAttribute() {
        return !empty($this->source_url);
    }

    public function getSourceSiteAttribute() {
        if(empty($this->source_url)){
            return "本站原创";
        } else {
            $host = parse_url($this->source_url, PHP_URL_HOST);
            $host = str_replace('www.', '', $host);
            return $host ? "来自 <a href=\"$this->source_url\" rel=\"external\" target='_blank'>$host</a>" : '转载自网络';
        }
    }

    public function getPublishTimeAttribute() {
        Carbon::setLocale('zh');

        return Carbon::parse($this->created_at)->diffForHumans();
    }

}
