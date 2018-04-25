<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta name="mobile-agent" content="format=html5;url= " />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="Keywords" content="前端开发,前端开发求职,前端开发新闻,前端开发前沿,前端开发博客,前端新知识,node.js,vue.js,devfeed,社区,最新前端,前端开发">
    <meta name="description" content="DevFeed（前端开发聚合），聚合前端开发业界最新、最热门、最有价值的文章" />
    <meta name="robots" content="all" />
    <meta name="author" content="Tencent-Tgideas" />
    <meta name="Copyright" content="Tencent" />
    <title>最新前端开发知识 -- DevFeed</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('v2017/css/common.css') }}">
        <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?a76c6abdae91d63f9be7ede27760f36b";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
<body>
<div class="wrap" id="app">
<router-view></router-view>
</div>

<script src="{{ asset('v2017/js/jquery.min.js') }}"></script>
<script src="{{ asset('v2017/js/comon.js') }}"></script>


<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/front.js') }}"></script>


</body>
</html>


