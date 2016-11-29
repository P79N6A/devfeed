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
        if($req->route()->getName() === 'api.site.list') {
            $size = $req->get('size', 20);
            $sites = Site::orderBy('id', 'desc')->paginate(20);
            return QuotaUtils::JsonResult($sites);
        } else {
            return view('backend.site');
        }
    }


    public function checkSite(Request $req) {
        if ($req->ajax()) {
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

            $site = new Site();
            $site->name = $req->get('name');
            $site->url = $req->get('url');
            $site->list_url = $req->get('list_url');
            $site->sel_link = $req->get('sel_link');
            $site->sel_title = $req->get('sel_title');
            $site->sel_content = $req->get('sel_content');
            $site->sel_tag = $req->get('sel_tag');
            $site->sel_author_link = $req->get('sel_author_link');
            $site->sel_author_name = $req->get('sel_author_name');

            try {
                $data = QuotaUtils::fetch($site, false);
                return QuotaUtils::JsonResult($data);
            } catch (Exception $e) {
                return QuotaUtils::JsonResult(null, $e->getCode(), $e->getMessage());
            }
        } else {
            throw new MethodNotAllowedHttpException(['ajax']);
        }
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
