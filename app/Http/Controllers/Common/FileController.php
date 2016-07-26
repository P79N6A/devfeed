<?php

namespace Fedn\Http\Controllers\Common;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

class FileController extends Controller
{
    /**
     * @param string $type
     */
    public function upload($type) {
        return response()->json(request()->all());
    }
}
