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
            @if(empty($item->figure))
            <div class="col-md-12">
            @else
            <div class="col-md-8">
            @endif
                <div class="artical-col">
                    <h3 class="ac-title">
                        {{ link_to('/article/'.$item->id, $item->title) }}
                        @foreach($item->tags as $tag)
                        <span class="ac-list-tag tag-bg-{{ ['red','blue','org'][random_int(0,2)] }}">{{ $tag->title }}</span>
                        @endforeach
                    </h3>
                    <div class="ac-info">
                        @if($item->isLink)
                        <span>{{ $item->updated_at }} 来自 {{ link_to($item->source_url) }}</span>
                        @else
                        <span>{{ $item->updated_at }} 本站原创</span>
                        @endif
                        <span><a href="#comments" title="点击立刻发表评论">暂无评论</a></span>
                    </div>
                    <div class="ac-detail">
                        {{ $item->description }}
                    </div>

                </div>
            </div>
            @if(!empty($item->figure))
            <div class="col-md-4">
                <a href="{{ url('/article/'.$item->id) }}"><img src="{{ asset($item->figure) }}" alt="$item->title"></a>
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
<script src="{{ asset('js/nav.js') }}"></script>
@endsection