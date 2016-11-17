<?php

namespace Fedn\Http\Controllers\Api;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Quota;
use Fedn\Utils\QuotaUtils;

class QuotaController extends Controller
{
    public function list(Request $req) {
        $tag = $req->request->get('tag', false);
        $site = $req->request->get('site', false);
        $size = $req->request->get('size', 10);
        $quotas = Quota::orderBy('id', 'desc');
        if($tag) {
            $quotas = $quotas->whereRaw('FIND_IN_SET(?, tags)',[$tag]);
        }
        if($site) {
            $quotas = $quotas->where('site_name', $site);
        }
        $data = $quotas->paginate($size);
        return QuotaUtils::JsonResult($data);
    }



    public function sites() {
        $rows = Quota::select('site_name')->distinct()->get();

        $data = [];
        foreach($rows as $row) {
            array_push($data,$row->site_name);
        }

        return QuotaUtils::JsonResult($data);
    }

    public function tags() {
        $rows = Quota::select('tags')->distinct()->get();
        $data = [];
        foreach($rows as $row) {
            $_tags = explode(',', $row->tags);
            $data = array_merge($data, $_tags);
        }
        $data = array_unique($data);
        list($keys, $data) = array_divide($data);
        return response()->json(QuotaUtils::JsonResult($data));
    }
}
