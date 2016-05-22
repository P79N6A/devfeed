<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Fedn\Models\Quote
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $slug
 * @property string $summary
 * @property string $content
 * @property string $link
 * @property string $author
 * @property string $author_link
 * @property string $from
 * @property string $from_link
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Fedn\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fedn\Models\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fedn\Models\Tag[] $tags
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereSummary($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereAuthorLink($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereFromLink($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Quote whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Quote extends Model
{
    use SoftDeletes;

    public function user() {
        return $this->belongsTo('Fedn\Models\User');
    }

    public function categories() {
        return $this->morphToMany('Fedn\Models\Category', 'classifiable');
    }

    public function tags() {
        return $this->morphToMany('Fedn\Models\Tag', 'taggable');
    }
}
