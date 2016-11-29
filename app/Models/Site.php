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

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->attributes['last_check'] = time();
    }
}
