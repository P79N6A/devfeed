<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public $timestamps = false;

    protected $table = 'spider';

    public function getIsLinkAttribute()
    {
        return !empty($this->source);
    }

    public function getSourceSiteAttribute()
    {
        if (empty($this->source)) {
            return "本站原创";
        } else {
            $host = parse_url($this->source, PHP_URL_HOST);
            return $this->website ? "来自 <a href=\"$this->source\" rel=\"external\" target='_blank'>$this->website</a>" : "来自 <a href=\"$this->source\" rel=\"external\" target=\"_blank\">$host</a>";
        }
    }
}
