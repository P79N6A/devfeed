@extends('v2017.layout')
@section('pageTitle', $currentPage)
@section('content_main')
    <div class="com-main">
        <div class="main-tt">
            <h2>{{$currentPage}}</h2>
            <div class="type-btns">
                <a href="javascript:void(0);" title="list" class="list spr hide on">list</a>
                <a href="javascript:void(0);" title="imte" class="item spr hide">item</a>
            </div>
        </div>
        <div class="main-con">
            <ul class="list clearfix"><!--通过类名list、item进行列表展示方式的切换-->
                @forelse($articles as $item)
                    <li>
                        <a href="javascript:void(0);" class="list-pic">
                            <img src="{{$item->previewImg?$item->previewImg:asset('v2017/images/default.jpg')}}" alt="" />
                        </a>
                        <h3>{{ link_to('/article/'.$item->id, $item->title) }}<span class="read-all spr">123</span></h3>
                        <p class="list-intro">{{ mb_substr(strip_tags($item->content), 0, 500) }}</p>
                        <p class="list-infor"><a href="javascript:void(0)" class="team">Tgideas</a>&#64;<a href="javascript:void(0)" class="people">{!! $item->sourceSite !!}</a><span class="time">{{ $item->publishTime }} </span></p>
                    </li>
                    @endforeach
            </ul>
            <ul class="pages">
                <li><a href="javascript:void(0);" title="" class="prev">&laquo;</a></li>
                <li class="active"><a href="javascript:void(0);">1</a></li></li>
                <li><a href="javascript:void(0);">2</a></li>
                <li><a href="javascript:void(0);">3</a></li>
                <li><a href="javascript:void(0);" title="" class="next">&raquo;</a></li>
            </ul>
        </div>
    </div>
@endsection