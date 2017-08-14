<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="description" content="Fedn"/>
<meta name="keywords" content="DevFeed,前端开发聚合"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('pageTitle', '首页') - DevFeed</title>
@yield('extraMeta')
<meta name="baidu-site-verification" content="zzaF8vP9Pc"/>
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/fedn.css') }}">
@yield('pageStyle')
<script>
  var _hmt = _hmt || [];
  (function () {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?26790bda6fb5f397d7e69299be124586";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
  })();
</script>
</head>
<body>
@include('front.partial.header')

@section('main')
@show

@include('front.partial.footer')
@yield('pageScript')

</body>
</html>

