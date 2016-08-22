<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $fillable = ['user_id', 'key', 'value'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
