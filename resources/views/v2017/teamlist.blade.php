@extends('v2017.layout')
@section('pageTitle', $currentPage)

@section('content_main')
    <div class="com-main">
        <div class="main-tt">
            <h2>{{$currentPage}}</h2>
        </div>
        <div class="main-con">
            <ul class="list clearfix"><!--通过类名list、item进行列表展示方式的切换-->
                @foreach($teamList as $item)
                    <li>
                        {{--                            <a href="{{link_to('front.team.detail/1')}}" title="{{$teamItem['title']}}">{{$teamItem['title']}}</a>--}}
                        <a href="javascript:void(0);" class="list-pic"><img src="{{$item->logo}}" alt="{{$item->title}}" /></a>
                        <h3>{{ link_to('/team/'.$item->id, $item->title) }}</h3>
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