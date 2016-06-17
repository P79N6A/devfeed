<?php

namespace Fedn\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function getIndex(){
        return view('backend.home');
    }
}
