<?php

namespace Fedn\Models;

use function explode;
use Illuminate\Database\Eloquent\Model;
use function preg_replace;

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
        //$_cont = preg_replace('/\n/', "<br>", $_cont);
        $_cont = preg_split('/\n+/', $_cont);
        $_html = '';
        foreach($_cont as $k => $item) {
            $_html .= "<p>$item</p>";
        }
        return $_html;
    }

    public function logoFile($ext = 'png')
    {
        return $this->id.".$ext";
    }
}
