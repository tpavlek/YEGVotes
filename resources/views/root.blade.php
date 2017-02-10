<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="@yield('meta_description', "Track the voting record and attendance of Edmonton City Councillors")">
    <meta name="author" content="Troy Pavlek">

    <title>@yield('title', "") - YEGVOTES.info</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#d4dad0">
    <link rel="stylesheet" href="/css/all.css"/>
    <script src="https://use.fontawesome.com/91c9d3ddd3.js"></script>

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
@yield('body')

<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script>
    $(document).ready(function() {
        $("input[type='checkbox']").click(function() {
            var thisId = $(this).attr('id');
            var otherChecks = $(this).parents('.motions').find('input:checked:not(#' + thisId + ')');
            otherChecks.each(function (index) {
                $(otherChecks[index]).removeAttr('checked');
            });

        });
    });
</script>
@yield('root_scripts')
</body>
</html>
