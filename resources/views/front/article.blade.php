@extends('front.layout')

@section('pageTitle', $art->title)

@section('main')
    <div class="break-nav">
        <div class="container clearfix">
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
                       <span class="read">{{ $art->click_count }}</span>次阅读
                    </p>
                </div>
                <div class="article-con">
                    <div class="article-intro">
                        <blockquote>{{ $art->summary }}</blockquote>
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
                    <li><a href="javascript:void(0);" title="">flash科普小文</a></li>
                    <li><a href="javascript:void(0);" title="">web前端缓存小结</a></li>
                    <li><a href="javascript:void(0);" title="">Rect进阶——高复用性组件设计</a></li>
                    <li><a href="javascript:void(0);" title="">基于highcharts实现实时数据动态展示基于highcharts实现实时数据动态展示</a></li>
                    <li><a href="javascript:void(0);" title="">flash科普小文</a></li>
                </ul>
            </div>
            <div class="recommend">
                <h3 class="article-side-tt">猜你喜欢</h3>
                <ul class="recommendlist">
                    <li><a href="javascript:void(0);" title="">flash科普小文</a></li>
                    <li><a href="javascript:void(0);" title="">web前端缓存小结</a></li>
                    <li><a href="javascript:void(0);" title="">Rect进阶——高复用性组件设计</a></li>
                    <li><a href="javascript:void(0);" title="">基于highcharts实现实时数据动态展示</a></li>
                    <li><a href="javascript:void(0);" title="">flash科普小文</a></li>
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