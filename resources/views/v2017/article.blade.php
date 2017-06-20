@extends('v2017.layout')

@section('pageTitle', $art->title)

@section('content_main')
<div class="com-main">
    <div class="main-con">
        <div class="article-top">
            <div class="break-nav">
                <a href="{{$nav['href']}}" title="{{$nav['name']}}">{{$nav['name']}}</a><em>&gt;</em><span>{{ $art->title }}</span>
            </div>
            <div class="share">
                <span>分享到：</span>
                <div id="tg-sns"></div>
            </div>
        </div>
        <div class="article-con">
            <div class="article-tt">
                <h3>{{$art->title}}</h3>
                <p class="article-infor">
                    <a href="javascript:void(0);" class="like"><i class="like-icon spr"></i><span class="like-num">166</span></a>
                    <a href="javascript:void(0)" class="team">Tgideas</a>&#64;<a href="javascript:void(0)" class="people">allanglwang</a><span class="time">{{ $art->publishTime }}</span></p>
            </div>
            <div class="article">
                {!! $art->content !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
    <script charset="gb2312" src="http://ossweb-img.qq.com/images/js/share/share-min.js"></script>
    <script type="text/javascript">
    ;TGshare({
        iconSize : 16,
        snsModule : ['wechat','qq','qzone','weibo','pengyou','sina','douban','kaixin','renren'],
        title : '腾讯游戏 - 用心创造快乐',
        url : 'location.href',
        picUrl : 'http://b.gtimg.com/res/2014/06/13/0/058e8b5f7aa4e83d.jpg',
        snsID :'tg-sns',
        isWindow : true,
        tcss : false
    });
</script>
@endsection
