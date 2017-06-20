<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Site extends Model
{
    protected $table = 'sites';

    protected $attributes = [
        'published' => false
    ];

    protected $guarded = [];

    public function getLastCheckAttribute() {
        if($this->attributes['last_check']) {
            Carbon::setLocale('zh');
            return Carbon::parse($this->attributes['last_check'])->diffForHumans();
        } else {
            return "N/A";
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo team()
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
