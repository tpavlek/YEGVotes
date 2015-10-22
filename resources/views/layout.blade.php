<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="Track the voting record and attendance of Edmonton City Councillors">
    <meta name="author" content="Troy Pavlek">

    <title>YEGVOTES @yield('title', "")</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/all.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
</head>
<body>
<header>
    <nav>
        <h1><a href="{{ URL::to('/') }}">YEGVotes</a></h1>
        <ul>
            <li>
                <a href="{{ URL::route('meetings.list') }}">Meetings</a>
            </li>
            @yield('additional_nav', '')
        </ul>
    </nav>
</header>
<div class="body-wrapper">
    @yield('content')
</div>
<footer>
    &copy; <a href="http://tpavlek.me">Troy Pavlek</a> {{ \Carbon\Carbon::now()->year }}.
    Data provided by <a href="https://data.edmonton.ca">Edmonton Open Data Catalogue</a>
</footer>
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
</body>
