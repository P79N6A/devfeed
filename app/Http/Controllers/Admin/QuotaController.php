<?php

namespace Fedn\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;



class QuotaController extends Controller
{
    public function list() {
        return view('backend.quota');
    }
}
