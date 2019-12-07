<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/favicon.png" type="image/png" />
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>NetLogger</title>
    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
</head>
<body>
@include('navbar')
<div class="container">
    @yield('content')
</div>

@yield('stats')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{mix('/js/app.js')}}"></script>
</body>
</html>