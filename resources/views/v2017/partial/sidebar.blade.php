<div class="side-menu">
    <div class="">
        <a href="javascript:void(0);" class="toggle-btn">
            <i class="hide-btn">收起</i>
            <i class="show-btn spr hide"></i>
        </a>
        <div class="side-menu-con">
            <div class="main-tag">
                <ul>
                    <li class="{{ URL::current() == route('front.home') ? 'on' : ' ' }}"><a href="{{route('front.home')}}" title="最新">最新</a></li>
                    <li class="{{ URL::current() == route('front.hot') ? 'on' : ' ' }}"><a href="{{route('front.hot')}}" title="最热">最热</a></li>
                </ul>
            </div>
            <div class="filter">
                @if($baseInfo['teamList'])
                    <dl>
                        <dt><i class="team spr"></i>团队</dt>
                         @foreach($baseInfo['teamList'] as $teamItem)
                            <dd>{{ link_to('/team/'.$teamItem->id, $teamItem->title) }}</dd>
{{--                            <a href="{{link_to('front.team.detail/1')}}" title="{{$teamItem['title']}}">{{$teamItem['title']}}</a>--}}
                         @endforeach
                        <dd><a href="{{route('front.team.index')}}" title="更多">更多&gt;&gt;</a></dd>
                    </dl>
                @endif

                {{--<dl>--}}
                    {{--<dt><i class="person spr"></i>人物</dt>--}}
                    {{--<dd><a href="javascript:void(0);" title="阮一峰">阮一峰</a></dd>--}}
                    {{--<dd><a href="javascript:void(0);" title="裁纸刀下">裁纸刀下</a></dd>--}}
                    {{--<dd><a href="javascript:void(0);" title="更多">更多&gt;&gt;</a></dd>--}}
                {{--</dl>--}}
            </div>
            {{--<div class="tags">--}}
            {{--<ul class="clearfix">--}}
            {{--<li><a href="javascript:void(0);" title="">vueJs</a></li>--}}
            {{--<li><a href="javascript:void(0);" title="">javascript</a></li>--}}
            {{--<li><a href="javascript:void(0);" title="">react</a></li>--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="subscribe"><a href="javascript:void(0);" title="订阅期刊">订阅期刊</a></div>--}}
        </div>
    </div>
</div>
