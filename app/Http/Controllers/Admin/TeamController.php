<?php

namespace Fedn\Http\Controllers\Admin;

use Fedn\Models\Team;
use Illuminate\Http\Request;
use Fedn\Http\Controllers\Controller;
use function view;

class TeamController extends Controller
{
    public function index()
    {
        return view('backend.team');
    }
}
