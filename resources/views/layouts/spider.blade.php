<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ? "$title - " : "" }}前端开发聚合 - DevFeed</title>
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }},前端开发,前端开发求职,前端开发新闻,前端开发前沿,前端开发博客,前端新知识,node.js,vue.js,devfeed,社区,最新前端,前端开发">
</head>
<body>
<header>
    <h2>{{ $title ? "$title - " : "" }}前端开发聚合 - DevFeed</h2>
    @yield('content')
</header>
</body>
</html>
