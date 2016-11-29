<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quota extends Model
{
    use SoftDeletes;

    protected $table = 'quotas';

    protected $guarded = [];
}
