<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'sites';

    protected $attributes = [
        'published' => false
    ];

    protected $guarded = [];

}
