@extends('v2017.layout')
@section('pageTitle', $currentPage)

@section('content_main')
    <div class="com-main">
        <div class="main-tt">
            <h2>{{$currentPage}}</h2>
        </div>
        <div class="main-con">
            <ul class="list clearfix"><!--通过类名list、item进行列表展示方式的切换-->
                <li>
                    <a href="{{ route('front.team.detail',$teamDetail->id) }}" class="list-pic"><img src="{{ $teamDetail->logo }}" alt="{{ $teamDetail->title }}" /></a>
                    <h3>{{ link_to(route('front.team.detail',$teamDetail->id), $teamDetail->title) }}</h3>
                    <p class="list-intro">{!! $teamDetail->descriptionHtml !!}</p>
                </li>
                @if($articleDetail->count())
                    @foreach($articleDetail as $item)
                        <li>
                            <a href="{{ route('front.article.view', $item->id) }}" class="list-pic">
                                @if($item->preview['type'] == 'img')
                                    <img src="{{$item->preview['src']}}" alt="" />
                                @else
                                    <span class="text text-{{ ['pink','purple','org','green'][random_int(0,3)]}}">{{$item->preview['src']}}</span>
                                @endif
                            </a>
                            <h3>{{ link_to(route('front.article.view', $item->id), $item->title) }}
                                @if($item->source_url)
                                    <a href="{!! $item->source_url !!}" target="_blank" class="origin-link"><i class="spr"></i></a>
                                @endif
                                <span class="read-all spr">{{ $item->click_count }}</span>
                            </h3>
                            <p class="list-intro">{{ mb_substr(strip_tags($item->summary), 0, 200) }}</p>
                            <p class="list-infor">

                                <a href="{{ route('front.team.detail',$item->team->id) }}" class="team">{{ $item->team->title }}</a>&#64;
                                <a href="javascript:void(0)" class="people">{{ $item->author }}</a><span class="time">{{ $item->publishTime }}</span>
                            </p>
                        </li>
                    @endforeach
                @else
                    <li class="no-data">暂无文章</li>
                @endif
            </ul>
            <div class="pages">
                {{ $articleDetail->links() }}
            </div>
        </div>
    </div>
@endsection
