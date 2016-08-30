@extends('front.layout')

@section('main')
    <div class="subway_wp">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <ul class="subway_nav">
                        <li class="current"><a href="#" title="最新">最新</a><span class="cor"></span></li>
                        <li><a href="#" title="最新">最新</a></li>
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
            @if(empty($art->figure))
            <div class="col-md-12">
            @else
            <div class="col-md-8">
            @endif
                <div class="artical-col">
                    <h3 class="ac-title">
                        {{ link_to('/article/'.$art->id, $art->title) }}
                        @foreach($art->tags as $tag)
                        <span class="ac-list-tag tag-bg-{{ ['red','blue','org'][random_int(0,2)] }}">{{ $tag->title }}</span>
                        @endforeach
                    </h3>
                    <div class="ac-info">
                        @if($art->isLink)
                        <span>{{ $art->updated_at }} 来自 {{ link_to($art->source_url) }}</span>
                        <span><a href="#comments" title="点击立刻发表评论">暂无评论</a></span>
                    </div>
                    <div class="ac-detail">
                        {{ $art->description }}
                    </div>

                </div>
            </div>
            @if(!empty($art->figure))
            <div class="col-md-4">
                <a href="{{ url('/article/'.$art->id) }}"><img src="{{ asset($art->figure) }}" alt="$art->title"></a>
            </div>
            @endif
        </div>
        @else
        <div class="row">
            <div class="col-md-12"><p class="muted">暂时没有文章</p></div>
        </div>
        @endforelse
    </div>
    <!-- 文章列表END -->

    <div class="container page_container">
        <nav>
            {{ $articles->link() }}
        </nav>
    </div>
    <!-- 分页END -->
@endsection

@section('pageScript')
<script src="{{ asset('js/nav.js') }}"></script>
@endsection