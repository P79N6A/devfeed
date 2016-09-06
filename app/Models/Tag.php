<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

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
        return $this->morphedByMany(Article::class, 'taggable');
    }
    public function getSourceSiteAttribute() {
        if(empty($this->source_url)){
            return "本站原创";
        } else {
            $host = parse_url($this->source_url, PHP_URL_HOST);
            return $host ? "来自 <a href=\"$this->source_url\" rel=\"external\">$host</a>" : '转载自网络';
        }
    }
    public function getPublishTimeAttribute() {
        Carbon::setLocale('zh');
        return Carbon::parse($this->created_at)->diffForHumans();
    }



}
