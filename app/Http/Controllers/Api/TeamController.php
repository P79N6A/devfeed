<?php

namespace Fedn\Http\Controllers\api;

use Illuminate\Http\Request;
use Fedn\Http\Controllers\Controller;
use Cache;
use Fedn\Models\Team;
use function is_numeric;

class TeamController extends Controller
{

    public function list(Request $req)
    {

        $page = $req->get('page', 1);
        $size = $req->get('size', 10);

        $cacheKey = 'teams_';

        $query = Team::orderBy('likes', 'desc')->orderBy('updated_at', 'desc');

        if($size == 0) {
            $cacheKey = 'teams_all';
        } else {
            $page = is_numeric($page) && $page > 0 ? $page : 1;
            $size = is_numeric($size) && $size < 500 ? $size : 10;
            $cacheKey = 'teams_'.$page;
        }

        $cacheExpiration = app()->isLocal() ? 0 : 60;

        $teams = Cache::remember($cacheKey, $cacheExpiration, function() use ($cacheKey, $query, $page, $size){
            $returnAll = $cacheKey === 'teams_all';

            $data = $returnAll ? $query->get() : $query->paginate($size, ['*'], 'page', $page);

            if($returnAll) {
                $total = $data->count();
                $data = [
                    'total'=>$total,
                    'per_page'=>$total,
                    'current_page'=>1,
                    'last_page'=>1,
                    'next_page_url'=>null,
                    'prev_page_url'=>null,
                    'from'=>1,
                    'to'=>$total,
                    'data' => $data
                ];
            }

            return $data;
        });

        return response()->json($teams);

    }
}
