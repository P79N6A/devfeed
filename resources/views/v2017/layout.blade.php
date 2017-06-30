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
    <meta name="robots" content="all" />
    <meta name="author" content=" " />
    <meta name="Copyright" content="Tencent" />
    <title>{{$baseInfo['title']}}--@yield('pageTitle', '首页')</title>
    <link rel="stylesheet" type="text/css" href="{{asset('v2017/css/common.css')}}">
<body>
<div class="wrap">
    @include('v2017.partial.sidebar')
    <div class="container">
        @include('v2017.partial.content_top')
        @section('content_main')
        @show
        <div class="com-footer">
            <p>Copyright © 2017 Tgideas</p>
            <p>粤ICP备14011364号-5</p>
        </div>
    </div>
</div>
<script src="{{asset('v2017/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('v2017/js/comon.js')}}"></script>
@yield('page_script')
</body>
</html>