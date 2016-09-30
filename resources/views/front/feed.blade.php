@extends('front.layout')

@section('pageTitle', $art->title)

@section('main')
    <div class="break-nav">
        <div class="container clearfix">

            <div class="nav-link">
                <a href="/" title="首页">首页</a><em>&gt;</em>
                <span>{{$art->title}}</span>
            </div>

            <div class="vote">
                <a href="" title="投稿给FEDN" class="contribution"><i class="contribution_ico"></i>我要投稿</a>
            </div>
         </div>

    </div>
    <!-- subnav end -->
    <div class="main-con container clearfix">
        <div class="col-md-8 col-xs-12 con">
            <div class="article">
                <div class="article-tt">
                    <h3>{{ $art->title }}</h3>

                   @if($art->author)
                    <p>作者：
                       @if($art->userHome) <a href="{{ $art->userHome }}" rel="external" target="_blank"> @endif
                       <span class="author">{{ $art->author }}</span>
                       @if($art->userHome) </a> @endif
                    </p>
                   @endif

                </div>
                <div class="article-con">
                    <div class="article-detail">
                        {!! $art->content !!}
                    </div>
                </div>

            </div>
        </div>
        <div class="detail-side col-md-4 col-xs-12">
            <div class="new-article">
                <h3 class="article-side-tt">最新文章</h3>
                <ul class="newlist">
                    @foreach($new as $key=> $n)
                        <li><a href="/feed/{{$n->id}}" title="{{$n->title}}">{{$n->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('pageScript')
    <script>
        var duoshuoQuery = {short_name: "webdn"};
        (function () {
            var ds = document.createElement('script');
            ds.type = 'text/javascript';
            ds.async = true;
            ds.src = '//static.duoshuo.com/embed.js';
            ds.charset = 'UTF-8';
            (document.getElementsByTagName('head')[0]
            || document.getElementsByTagName('body')[0]).appendChild(ds);
        })();
    </script>
@endsection