@extends('front.layout')
@section('pageTitle',$Tags->title.'-前端开发标签')
@section('main')
    <div class="break-nav">
        <div class="container clearfix">
            <div class="nav-link">
                <a href="/" title="首页">首页</a><em>&gt;</em>
                <a href="/tag/" title="标签">标签</a><em>&gt;</em>
                <span>{{$Tags->title}}</span>
            </div>

            <div class="vote">
                <a href="" title="投稿给FEDN" class="contribution"><i class="contribution_ico"></i>我要投稿</a>
            </div>


        </div>
    </div>

    <div class="banner">
        <div class="container">
            <div class="row">

                @if(empty($Tags->figure))
                    <div class="col-md-12 topic-intro">
                        <h3>{{$Tags->title}}</h3>
                        <p>{{$Tags->description}}</p>
                    </div>
                @else
                    <div class="col-md-8 topic-intro">
                        <h3>{{$Tags->title}}</h3>
                        <p>{{$Tags->description}}</p>
                    </div>
                    <div class="col-md-4 topic-pic">
                        <img src="{{$Tags->figure}}" alt="{{$Tags->title}}">
                    </div>

                @endif


            </div>
        </div>
    </div> {{--Banner END--}}

    <div class="main container clearfix">
        <div class="main-list col-md-9">
           @if(count($Arts) == 0)
                <div class="mai-list-item clearfix">
                    <div class="col-md-12">
                           <p>暂时未收录{{$Tags->title}}标签相关的文章 :<</p>
                        </div>
                    </div>
               @else
            @foreach($Arts as $key=>$Art)
                <div class="mai-list-item clearfix">
               @if(empty($Art->figure))
                    <div class="col-md-12">
                        @else
                            <div class="col-md-8">
                   @endif
                                <div class="artical-col">
                                    <h3 class="ac-title"><a href="/article/{{$Art->id}}" title="{{$Art->title}}">{{$Art->title}}</a>
                                        @foreach($Art->tags as $tag)
                                            <a class="ac-list-tag tag-bg-{{ ['red','blue','org'][random_int(0,2)] }}" href="{{route('front.tag.index')}}/{{$tag->id}}">{{ $tag->title }}</a>
                                        @endforeach</h3>
                                    <div class="ac-info">

                                        <span>{{ $Art->publishTime }} {!! $Art->sourceSite !!}</span>
                                        <span><a href="{{ url('article/'.$Art->id.'#comments') }}"><span class="ds-thread-count" data-thread-key="{{$Art->id}}">暂无评论</span></a></span>
                                    </div>
                                    @if(!empty($Art->summary))
                                    <div class="ac-detail">
                                        {{$Art->summary}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @if(!empty($Art->figure))
                            <div class="col-md-4">
                                <a href="/article/{{$Art->id}}" title="{{$Art->title}}"><img src="{{$Art->figure}}" alt="{{$Art->title}}"></a>
                            </div>
                            @endif
                    </div>
            @endforeach

          @endif

                   <div class="container page_container">
                       <nav>
                           {{ $Arts->links() }}
                       </nav>
                   </div>
                   <!-- 分页END -->

        </div>
        <div class="side col-md-3">
            <div class="side-tt">
                <h3>相关标签</h3>
                <a href="/tag/" class="more-btn">更多》</a>
            </div>
            <ul class="side-list">
                @foreach($allTags as $key=>$t )
                        <li>
                            <h4><a href="{{route('front.tag.index')}}/{{$t->id}}" title="{{$t -> title}}">{{$t -> title}}</a></h4>
                            @if(isset($t -> description))
                                <p>{{$t -> description}}</p>
                                @endif

                        </li>
                    @endforeach
            </ul>
        </div>
    </div>

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