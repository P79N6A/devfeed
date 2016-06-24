<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['title', 'description'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
