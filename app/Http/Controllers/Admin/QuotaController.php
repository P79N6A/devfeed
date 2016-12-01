<?php

namespace Fedn\Http\Controllers\Admin;

use Carbon\Carbon;
use Fedn\Jobs\PublishFeedArticle;
use Fedn\Models\Quota;
use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Site;
use Fedn\Utils\QuotaUtils;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Artisan;


class QuotaController extends Controller
{
    public function list() {
        return view('backend.quota');
    }

    public function publish($id) {
        if($id === null || empty($id) || is_numeric($id) === false) {
            return QuotaUtils::JsonResult(null, 422, '参数id必须是数字');
        }

        $quota = Quota::find($id);
        if($quota) {
            $job = (new PublishFeedArticle($quota))->onQueue('publishing');
            dispatch($job);
            return QuotaUtils::JsonResult('任务已排入队列，请稍候。');
        } else {
            return QuotaUtils::JsonResult('稿件不存在，可能已被删除或已发布。', 404, '稿件不存在，可能已被删除或已发布。');
        }
    }

    public function delete($id) {
        if($id === null || empty($id) || is_numeric($id) === false) {
            return QuotaUtils::JsonResult(null, 422, '参数id必须是数字');
        }
        $quota = Quota::destroy($id);

        return QuotaUtils::JsonResult("操作成功，删除了 $quota 篇稿件");
    }

    public function sites(Request $req) {
        if($req->route()->getName() === 'api.site.list') {
            $size = $req->get('size', 20);
            $sites = Site::orderBy('id', 'desc')->paginate($size);
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

    public function fetchSite($id) {
        if($id === null || empty($id) || is_numeric($id) === false) {
            return QuotaUtils::JsonResult(null, 422, '参数id必须是数字');
        }

        set_time_limit(600);
        $exitCode = Artisan::call('fedn:fetch', ['site' => $id]);


        $results = $exitCode === 0 ? QuotaUtils::JsonResult('抓取任务已成功执行') : QuotaUtils::JsonResult('', $exitCode, '任务执行失败，请查看系统日志');

        return $results;
    }

    public function delSite($id) {
        if($id === null || empty($id) || is_numeric($id) === false) {
            return QuotaUtils::JsonResult(null, 422, '参数id必须是数字');
        }

        $result = Site::destroy($id);
        return QuotaUtils::JsonResult($result);
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
                'sel_author_name' => 'required',
                'published' => 'bool'
            ]);
            $data = $req->only(['name','url','list_url','sel_link','sel_title',
              'sel_content','sel_tag','sel_author_link','sel_author_name', 'published']);

            $site = Site::updateOrCreate(['list_url'=>$data['list_url']], $data);
            return QuotaUtils::JsonResult($site);
        } else {
            throw new MethodNotAllowedHttpException(['ajax']);
        }
    }
}
