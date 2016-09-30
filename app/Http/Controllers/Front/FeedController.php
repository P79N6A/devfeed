<?php

namespace Fedn\Http\Controllers\Front;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Feed;
use Cache;

class FeedController extends Controller
{

    public function list() {
        $page = request()->input('page', 1);
        if (is_numeric($page) == false) {
            $page = 1;
        }
        $feeds = Cache::remember('feeds_' . $page, 10, function () {
            return Feed::orderBy('id', 'desc')->paginate(10);
        });
        return view('front.feeds-list', ['articles' => $feeds]);
    }

    public function view($id) {
        $newFeeds = Feed::where('id', '!=', $id)->orderBy('id', 'desc')->take(5)->get();
        $feed = Feed::findOrFail($id);

        return view('front.feed', ['art' => $feed, 'new' => $newFeeds]);
    }
}
