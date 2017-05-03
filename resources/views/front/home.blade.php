@extends('front.layout')

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
                {{--<div class="col-md-3">
                    <a href="" title="投稿给FEDN" class="contribution"><i class="contribution_ico"></i>我要投稿</a>
                </div>--}}
            </div>
        </div>
    </div>
    <!-- subnav end -->
    <div class="list-col container">
        @forelse($articles as $item)
        <div class="row">
            @if(empty($item->figure))
            <div class="col-md-12">
            @else
            <div class="col-md-8">
            @endif
                <div class="artical-col">
                    <h3 class="ac-title">
                        {{ link_to('/article/'.$item->id, $item->title) }}
                        @foreach($item->tags as $tag)
                        <a class="ac-list-tag tag-bg-{{ ['red','blue','org'][random_int(0,2)] }}" href="{{route('front.tag.detail', $tag->id)}}">{{ $tag->title }}</a>
                        @endforeach
                    </h3>
                    <div class="ac-info">
                        <span>{{ $item->publishTime }} {!! $item->sourceSite !!}</span>
                        <a href="{{ url('article/'.$item->id.'#SOHUCS') }}">评论：<span id="sourceId::{{$item->id}}" class="cy_cmt_count">0</span></a>
                    </div>
                    <div class="ac-detail">
                        {{ mb_substr(strip_tags($item->content), 0, 500) }}
                    </div>

                </div>
            </div>
            @if(!empty($item->figure))
            <div class="col-md-4">
                <a href="{{ url('/article/'.$item->id) }}"><img src="{{ asset($item->figure) }}" alt="{{$item->title}}"></a>
            </div>
            @endif
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
<script id="cy_cmt_num" src="https://changyan.sohu.com/upload/plugins/plugins.list.count.js?clientId=cysYDvnSW"></script>
@endsection
