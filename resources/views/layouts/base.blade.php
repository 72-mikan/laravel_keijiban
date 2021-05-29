<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>@yield('title')</title>
<link rel="stylesheet" href="{{asset('css/')}}" />
</head>
<body>
<hr />
@section('main')
<p>既定のコンテンツです。</p>
@show
<hr />
<p>Copyright(c) 2021,Natsumikan. All Rights Reserved.</p>
</body>
</html>