<?php

namespace Fedn\Models;

use Illuminate\Database\Eloquent\Model;
use Parsedown;

class Team extends Model
{
    public const LOGO_PATH = 'upload/teams';
    protected $guarded = ['created_at', 'updated_at'];
    protected $appends = ['description_html'];

    protected $attributes = [
        'logo' => '',
        'likes' => 0
    ];


    public function getDescriptionHtmlAttribute(){
        $_cont = $this->attributes['description'];
        $_parser = Parsedown::instance('fedn');
        $_html = $_parser->text($_cont);
        return $_html;
    }

    public function logoFile($ext = 'png')
    {
        $str = $this->id ?: $this->title;
        $str = substr(md5($str.'TEAM'), 8, 16);
        return $str.".$ext";
    }
}
