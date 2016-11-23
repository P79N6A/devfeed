<?php

namespace Fedn\Http\Controllers\Admin;

use Fedn\Models\Quota;
use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Site;
use Fedn\Utils\QuotaUtils;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class QuotaController extends Controller
{
    public function list() {
        return view('backend.quota');
    }

    public function sites(Request $req) {
        if($req->ajax()) {
            $size = $req->get('size', 20);
            $sites = Site::orderBy('id', 'desc')->paginate(20);
            return QuotaUtils::JsonResult($sites);
        }
        return view('backend.site');
    }

    public function saveSite(Request $req) {
        if($req->ajax()) {
            $this->validate($req, [
                'name' => 'required',
                'url' => 'required|url',
                'list_url' => 'required|url',
                'sel_link' => 'required',
                'sel_title' => 'required',
                'sel_content' => 'required',
                'sel_tag' => 'required',
                'sel_author_link' => 'required',
                'sel_author_name' => 'required'
            ]);
            $data = $req->request->all();

            $site = Site::updateOrCreate(['list_url'=>$data['list_url']], $data);
            return QuotaUtils::JsonResult($site);
        } else {
            throw new MethodNotAllowedHttpException(['ajax']);
        }
    }
}
