@extends('front.layout')

@section('pageTitle', '前端文章聚合')

@section('main')
    <div class="subway_wp">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <ul class="subway_nav">
                        <li class="current"><a href="javascript:void('')" title="最新">最新</a></li>
                        {{--<li><a href="#" title="最新">最新</a></li>--}}
                    </ul>
                </div>
                <div class="col-md-3">
                    <a href="" title="投稿给FEDN" class="contribution"><i class="contribution_ico"></i>我要投稿</a>
                </div>
            </div>
        </div>
    </div>
    <!-- subnav end -->
    <div class="list-col container">
        @forelse($articles as $item)
        <div class="row">
            <div class="col-md-12">
                <div class="artical-col">
                    <h3 class="ac-title">
                        {{ link_to('/feed/'.$item->id, $item->title) }}
                    </h3>
                    <div class="ac-info">
                        <span>作者：</span>
                        {{ link_to($item->userHome, $item->author) }}

                    </div>
                    <div class="ac-detail">
                        {{ mb_substr(strip_tags($item->content), 0, 500) }}
                    </div>

                </div>
            </div>
        </div>
        @empty
        <div class="row">
            <div class="col-md-12"><p class="muted">暂时没有文章</p></div>
        </div>
        @endforelse
    </div>
    <!-- 文章列表END -->

    <div class="container page_container">
        <nav>
            {{ $articles->links() }}
        </nav>
    </div>
    <!-- 分页END -->
@endsection

@section('pageScript')
<script type="text/javascript">
    var duoshuoQuery = {short_name: "webdn"};
    (function () {
        var ds = document.createElement('script');
        ds.type = 'text/javascript';
        ds.async = true;
        ds.src = '//static.duoshuo.com/embed.js';
        ds.charset = 'UTF-8';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
    })();
</script>
@endsection