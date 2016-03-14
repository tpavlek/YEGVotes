<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="@yield('meta_description', "Track the voting record and attendance of Edmonton City Councillors")">
    <meta name="author" content="Troy Pavlek">

    <title>YEGVOTES @yield('title', "")</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#d4dad0">
    <link rel="stylesheet" href="/css/all.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
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
