<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/home/weui/weui.css">
    <link rel="stylesheet" href="/home/css/example.css">
    <script src="/home/weui/weui.js"></script>
    <script src="/home/js/zepto.min.js"></script>
    <script src="/home/js/example.js"></script>
    @yield('extend')
</head>
<body>
@yield('content')
</body>
</html>
@yield('my-js')