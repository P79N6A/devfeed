<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Fedn\Models\Category
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property integer $pid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Category whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Category wherePid($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fedn\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    public function articles() {
        return $this->morphedByMany('Fedb\Models\Article','classifiable');
    }

    public function quotes() {
        return $this->morphedByMany('Fedn\Models\Quote', 'classifiable');
    }
}
