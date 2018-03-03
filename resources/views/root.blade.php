<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="@yield('meta_description', "Track the voting record and attendance of Edmonton City Councillors")">
    <meta name="author" content="Troy Pavlek">

    <title>@yield('title', "") YEGVOTES.info</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#d4dad0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

    <link rel="stylesheet" href="/css/app.css"/>



    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@troypavlek" />

    <meta name="twitter:title" content="@yield('title', 'Main Page') - YEGVotes.info" />
    <meta property="og:title" content="@yield('title', 'Main Page') - YEGVotes.info" />

    <meta name="twitter:description" content="@yield('meta_description', "Track the voting record and attendance of Edmonton City Councillors")" />
    <meta property="og:description" content="@yield('meta_description', "Track the voting record and attendance of Edmonton City Councillors")" />

    <meta name="twitter:image" content="{{ URL::to('/') }}@yield('meta_image', '/img/vote.png')" />
    <meta property="og:image" content="{{ URL::to('/') }}@yield('meta_image', '/img/vote.png')" />

    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="article" />
</head>
<body>
<div id="app">
    <div class="bg-orange-lightest">
        @yield('body')
    </div>
</div>

<script src="/js/app.js"></script>
@yield('root_scripts')
</body>
</html>
