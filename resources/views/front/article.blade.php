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
                    <p><span class="date">{{ $art->publishTime }}</span>
                       @if($art->author) by
                           @if($art->author_url) <a href="{{ $art->author_url }}" rel="external" target="_blank"> @endif
                           <span class="author">{{ $art->author }}</span>
                           @if($art->author_url) </a> @endif
                       @endif
                       <span class="read">{{ $art->click_count }}</span>次阅读
                    </p>
                </div>
                <div class="article-con">
                    <div class="article-intro">

                            @if($art->source_url != '')
                                <p class="see_souce_link"><a href="{{ $art->source_url }}" target="_blank">访问 《{{ $art->title }}》原文</a></p>
                            @endif


                    </div>
                    <div class="article-detail">
                         {!! $art->content !!}
                    </div>
                </div>
                <a href="#comment" class="comment-btn"><span class="ds-thread-count comment-num" data-thread-key="{{ $art->id }}" data-count-type="comments">暂无评论</span></a>
            </div>
            <div class="comment" id="comment">
                <div class="comments">
                    <a name="comments"></a>
                    <div class="ds-thread" data-thread-key="{{ $art->id }}" data-title="{{ $art->title }}" data-url="{{ url('/article/'.$art->id) }}"></div>
                </div>
            </div>
        </div>
        <div class="detail-side col-md-4 col-xs-12">
            <div class="new-article">
                <h3 class="article-side-tt">最新文章</h3>
                <ul class="newlist">
                    @foreach($new as $key=> $n)
                        <li><a href="/article/{{$n->id}}" title="{{$n->title}}">{{$n->title}}</a></li>
                        @endforeach
                </ul>
            </div>
            <div class="recommend">
                <h3 class="article-side-tt">猜你喜欢</h3>
                <ul class="recommendlist">
                    @foreach($like as $key=> $l)
                        <li><a href="/article/{{$l->id}}" title="{{$l->title}}">{{$l->title}}</a></li>
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