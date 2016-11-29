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

    public function __construct(array $attributes = []) {

        if(!array_key_exists('last_check', $attributes)) {
            $attributes['last_check'] = time();
        }
        parent::__construct($attributes);
    }

    public function getLastCheckAttribute() {
        if($this->attributes['last_check']) {
            Carbon::setLocale('zh');
            return Carbon::parse($this->attributes['last_check'])->diffForHumans();
        } else {
            return "N/A";
        }
    }
}
