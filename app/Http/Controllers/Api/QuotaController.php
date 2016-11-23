<?php

namespace Fedn\Http\Controllers\Api;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Quota;
use Fedn\Utils\QuotaUtils;
use Symfony\Component\Routing\Exception\InvalidParameterException;

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
        $quotas->select('id','title','content','url','tags','site_url','site_name','author_url','author_name','created_at','updated_at');
        $data = $quotas->paginate($size);

        foreach($data as $item) {
            $content = trim(strip_tags($item->content), "　 \t\n\r\v");
            $content = str_replace("\n","", $content);
            $item->content = mb_substr($content, 0, 140, 'utf8');
        }
        return QuotaUtils::JsonResult($data);
    }

    public function detail(Request $req) {
        $id = $req->get('id', 0);

        if(!is_numeric($id) || (int)$id != $id) {
            return QuotaUtils::JsonResult(null, 40035, 'Invalid parameters.');
        }

        $quota = Quota::find($id);
        if(!$quota) {
            return QuotaUtils::JsonResult(null, 46001, 'Article not found.');
        } else {
            return QuotaUtils::JsonResult($quota);
        }
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
