@extends('layouts.spider')

@section('content')
<nav role="navigation">
    <a href="/new" title="最新文章列表">最新文章</a>
    <a href="/hot" title="热门文章列表">热门文章</a>
    <a href="/teams" title="查看所有团队">团队</a>
</nav>
@if(count($articles))
    <div id="articleList">
        @foreach($articles as $item)
            <article class="article">
                <h1 id="title">{{ $item->title }}</h1>
                <p id="summary">{{ $item->summary }}</p>
                <div id="author">
                    <a href="{{ $item->author_url }}" title="作者主页" rel="external, no-follow">{{ $item->author }}</a>
                </div>
            </article>
        @endforeach
    </div>
    <nav id="pager" role="navigation">
        {{ $articles->links() }}
    </nav>
@endif
@endsection
