@extends('v2017.layout')
@section('pageTitle', '业界前端'.$currentPage)
@section('Keywords', '前端,前端开发博客,前端开发名人,前端开发')

@section('content_main')
    <div class="com-main">
        <div class="main-tt">
            <h2>{{$currentPage}}</h2>
        </div>
        <div class="main-con">
            <ul class="list clearfix"><!--通过类名list、item进行列表展示方式的切换-->
                @foreach($teamList as $item)
                    <li>
                        <a href="{{route('front.team.detail', $item->id)}}" class="list-pic team-logo"><img src="{{ $item->logo }}" alt="{{ $item->title }}" /></a>
                        <h3>{{ link_to(route('front.team.detail', $item->id), $item->title) }}<span class="article-num">{{$item->articles_count}}篇文章</span></h3>
                        <p class="list-intro">{!! $item->descriptionHtml !!}</p>
                    </li>
                @endforeach
            </ul>
            <div class="pages">
                {{ $teamList->links() }}
            </div>
        </div>
    </div>
@endsection
