<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="description" content="Fedn"/>
<meta name="keywords" content="FEDN,前端开发"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('pageTitle', '首页') - FEDN</title>
@yield('extraMeta')
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/fedn.css') }}">
@yield('pageStyle')
</head>
<body>
@include('front.partial.header')

@section('main')
@show

@include('front.partial.footer')
@yield('pageScript')

</body>
</html>

