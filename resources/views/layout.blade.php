@extends('root')

@section('body')
<header>
    <nav>
        <h1><a href="{{ URL::to('/') }}">YEGVotes</a></h1>
        <ul>
            <li>
                <a href="{{ URL::route('elections.2017') }}">2017 Election</a>
            </li>
            <li>
                <a href="{{ URL::route('meetings.list') }}">Meetings</a>
            </li>
            <li>
                <a href="{{ URL::route('about') }}">About</a>
            </li>
            <li>
                <a href="{{ URL::route('stats') }}">Stats</a>
            </li>
            <li>
                <a href="https://basketofyegs.com">Podcast</a>
            </li>
            @yield('additional_nav', '')
        </ul>
    </nav>
</header>
@include('vendor.toolbox.errors.errorPartial')
<div class="body-wrapper">
    @yield('content')
</div>
<footer>
    &copy; <a href="http://tpavlek.me">Troy Pavlek</a> {{ \Carbon\Carbon::now()->year }}.
    Data provided by <a href="https://data.edmonton.ca">Edmonton Open Data Catalogue</a>
</footer>


@stop

@section('root_scripts')
    @include('javascript')
    @yield('scripts', "")
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '1103500426336483',
                xfbml      : true,
                version    : 'v2.5'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-69189501-1', 'auto');
        ga('send', 'pageview');

    </script>
@stop
