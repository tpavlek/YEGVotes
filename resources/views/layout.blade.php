<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/css/all.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>
<header>
    <nav>
        <h1><a href="{{ URL::to('/') }}">YEGVotes</a></h1>
        <ul>
            <li>
                <a href="{{ URL::route('meetings.list') }}">Meetings</a>
            </li>
        </ul>
    </nav>
</header>
<div class="body-wrapper">
    @yield('content')
</div>
</body>
