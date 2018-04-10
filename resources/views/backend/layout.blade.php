<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield('extraMeta')
<title>FEDN @yield('pageTitle', '管理中心')</title>
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ mix('css/backend.css') }}">
@yield('pageStyle')
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('admin.home') }}">FEDN 管理中心</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('admin.home') }}">管理首页</a></li>
                <li><a href="{{ url('admin/settings') }}">系统设置</a></li>
                <li><a href="{{ url('profile') }}">个人账户</a></li>
                <li><a href="{{ url('help') }}">帮助</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="wrapper">
        <div class="sidebar sidebar-menus">
            <div class="list-group">
                <a class="list-group-item{{ request()->is('admin') ? ' active':null }}" href="{{ route('admin.home') }}">概况 <span class="sr-only">(current)</span></a>
                <a class="list-group-item{{ request()->is('admin/role*') ? ' active':null }}" href="{{ route('admin.roles') }}">角色</a>
                <a class="list-group-item{{ request()->is('admin/user*') ? ' active':null }}" href="{{ route('admin.users') }}">用户</a>
            </div>
            <div class="list-group">
                <a class="list-group-item{{ request()->is('admin/article*') ? ' active':null }}" href="{{ url('admin/articles') }}">文章</a>
                <a class="list-group-item{{ request()->is('admin/specials*') ? ' active':null }}" href="{{ url('admin/specials') }}">专题</a>
                <a class="list-group-item{{ request()->is('admin/tag*') ? ' active':null }}" href="{{ url('admin/tags') }}">标签</a>
                <a class="list-group-item{{ request()->is('admin/team*') ? ' active':null }}" href="{{ url('admin/team') }}">团队</a>
            </div>
            <div class="list-group">
                <a class="list-group-item{{ request()->is('admin/quotas') ? ' active':null }}" href="{{ url('admin/quotas') }}">采集</a>
                <a class="list-group-item{{ request()->is('admin/sites') ? ' active':null }}" href="{{ url('admin/sites') }}">源站</a>
                <a class="list-group-item{{ request()->is('admin/authors') ? ' active':null }} disabled" href="{{ url('admin/authors') }}">作者</a>
            </div>

            <div class="list-group">
                <a class="list-group-item{{ request()->is('admin/quotas') ? ' active':null }}" href="{{ url('admin/quotas') }}">邮件</a>
            </div>
        </div>
        <div class="main">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('admin.home') }}">Home</a>
                </li>
                <li class="active">Link</li>
            </ol>
            @section('content')
            <h1 class="page-header">Dashboard</h1>
            @show
        </div>
    </div>
</div>
@yield('pageScript')
</body>
</html>
