<?php

namespace Fedn\Http\Controllers\api;

use Illuminate\Http\Request;
use Fedn\Http\Controllers\Controller;
use Cache;
use Fedn\Models\Team;

class TeamController extends Controller
{

    public function list(Request $req)
    {

        $teams = app()->isLocal() ? Team::all() : Cache::remember('teams_list', 60, function () {
            return Team::all();
        });

        return response()->json($teams);

    }
}
