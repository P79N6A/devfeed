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
                <a href="#SOHUCS" class="comment-btn"><span id="changyan_count_unit"></span>条评论</a>
            </div>
            <div class="comment" id="comment">
                <div class="comments">
                    <div id="SOHUCS" sid="{{ $art->id }}" ></div>
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
(function(){
    var appid = 'cysYDvnSW';
    var conf = 'prod_9ecdc416526df4ef4273da69d4a7b3be';
    var loadJs=function(d,a){
        var c=document.getElementsByTagName("head")[0]||document.head||document.documentElement;
        var b=document.createElement("script");
        b.setAttribute("charset","UTF-8");
        b.setAttribute("src",d);
        if(typeof a==="function"){
            if(window.attachEvent){
                b.onreadystatechange=function(){
                    var e=b.readyState;
                    if(e==="loaded"||e==="complete"){
                        b.onreadystatechange=null;
                        a();
                    }
                }
            }else{
                b.onload=a;
            }
        }
        c.appendChild(b);
    };
    loadJs("https://changyan.sohu.com/upload/changyan.js",function(){
        window.changyan.api.config({appid:appid,conf:conf});
    });
    loadJs("https://assets.changyan.sohu.com/upload/plugins/plugins.count.js");
}());
</script>
@endsection
