<!DOCTYPE>
<html>
<head>
    <meta charset="gbk">
    <meta name="mobile-agent" content="format=html5;url= " />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="Keywords" content="前端开发,前端开发求职,前端开发新闻,前端开发前沿,前端开发博客,前端新知识,node.js,vue.js,devfeed,社区,@yield('Keywords')">
    <meta name="description" content="DevFeed（前端开发聚合），聚合前端开发业界最新、最热门、最有价值的文章" />
    <meta name="robots" content="all" />
    <meta name="author" content="Tencent-Tgideas" />
    <meta name="Copyright" content="Tencent" />
    <title>@yield('pageTitle', '首页') -- {{$baseInfo['title']}}</title>
    <link rel="stylesheet" type="text/css" href="{{asset('v2017/css/common.css')}}">
    @yield('page_style')
<body>
<div class="wrap">
    @include('v2017.partial.sidebar')
    <div class="container">
        @include('v2017.partial.content_top')
        @section('content_main')
        @show
        <div class="com-footer">
            <p>Copyright © 2017 Tgideas</p>
            <p>粤ICP备14011364号-4</p>
        </div>
    </div>
</div>
<script src="{{asset('v2017/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('v2017/js/comon.js')}}"></script>
@yield('page_script')
</body>
</html>
