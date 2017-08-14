<div class="com-top">
    <a class="uk-button" data-uk-offcanvas="{target:'#sideMenu'}"><i class="show-btn spr hide"></i></a>
    <h1 class="logo"><a href="{{ route('front.home') }}" title="DevFeed" class="hide">DevFeed</a></h1>
    <div class="login">
        @if (Auth::guest())
            <div class="unlogin"><a href="{{ route('login') }}" class="spr">登录</a></div>
        @else
            <div class="logined"><a href="{{ route('logout') }}" class="spr">注销</a></div>
        @endif
    </div>

</div>
