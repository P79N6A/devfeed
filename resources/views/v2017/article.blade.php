@extends('v2017.layout')

@section('pageTitle', $art->title)
@section('Keywords','前端,前端开发,'.$art->title)

@section('page_style')
    <link rel="stylesheet" href="{{ asset('css/code/tomorrow-night.min.css') }}">
    <link rel="stylesheet" href="//game.gtimg.cn/images/js/devfeed/v2017/ossweb-img/css/crayon.min.css">

@endsection
@section('content_main')
<div class="com-main">
    <div class="main-con">
        <div class="article-top">
            <div class="break-nav">
                <a href="{{$nav['href']}}" title="{{$nav['name']}}">{{$nav['name']}}</a><em>&gt;</em><span>{{ $art->title }}</span>
            </div>
            {{--<div class="share">
                <span>分享到：</span>
                <div id="tg-sns"></div>
            </div>--}}
        </div>

        <div class="article-con">
            <div class="article-tt">
                <h3>{{$art->title}}</h3>
                <p class="article-infor">
                    <a href="{{ route('front.team.detail',$art->team['id'])}}" class="team">{{$art->team['title']}}</a>&#64;<a href="javascript:void(0)" class="people">{{$art->author}}</a><span class="time">{{ $art->publishTime }}</span>
                    @if($art->source_url)
                        <a href="{!! $art->source_url !!}" class="origin-link"><i class="spr"></i>查看原文</a>
                    @endif
                </p>
            </div>
            <div class="article">
                {!! $art->content !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
{{--
<script charset="gb2312" src="//game.gtimg.cn/images/js/share/share-min.js"></script>
<script src="{{ asset('js/code/highlight.min.js') }}"></script>
<script>
TGshare({
    iconSize : 16,
    snsModule : ['wechat','qq','qzone','sina'],
    title : '{{ $art->title }}',
    url : location.href,
    picUrl : '',
    snsID :'tg-sns',
    isWindow : true,
    tcss : false
});
hljs.initHighlighting();
</script>
--}}
@endsection
