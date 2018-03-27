<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;

class RemoteFile extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
