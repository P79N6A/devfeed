@extends('front.layout')
@section('pageTitle', '前端开发标签')
@section('main')
    <div class="break-nav">
        <div class="container clearfix">
            <div class="nav-link">
                <a href="/" title="首页">首页</a><em>&gt;</em>
                <span>前端开发标签</span>
            </div>
            <div class="vote">
                <a href="" title="投稿给FEDN" class="contribution"><i class="contribution_ico"></i>我要投稿</a>
            </div>
        </div>
    </div>
    <!-- subnav end -->
    <div class="tag container">
        <ul class="row tag-list">


            @foreach($tags as $key => $t)

                    @if(empty($t->figure))
                         <?php
                                $is = 'img/tag-list.jpg';
                          ?>
                        @else
                            <?php
                                $is = $t->figure;
                            ?>
                        @endif

                    <li class="col-md-4 col-sm-6 col-xs-12">
                        <div class="list-con clearfix">
                            <a href="{{route('front.tag.index')}}/{{$t->id}}" class="col-xs-4 tag-pic"><img src="{{ $is}}"></a>
                            <div class="tag-infor col-xs-8">
                                <h3 class="text-overflow"><a href="{{route('front.tag.index')}}/{{$t->id}}">{{$t->title}}</a></h3>
                                <p class="tag-time">创建于{{ $t->publishTime }}</p>
                                <p class="tag-num">已收录{{$t->articles->count()}}篇文章</p>
                            </div>
                        </div>
                    </li>

                @endforeach

        </ul>

        <div class="container page_container">
            <nav>
                {{$tags->links() }}
            </nav>
        </div>
    </div>
    {{--tag END--}}
@endsection
