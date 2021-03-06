@extends('layout')

@section('title', "Edmonton Ward 12 By-Election")

@section('content')

    <h1>Edmonton Ward 12 By-Election
        <small style="color:goldenrod">{{ (new \Carbon\Carbon('2016-02-22'))->format('M j, Y') }}</small>
    </h1>
    <div class="whitecard">
        <h2>Moe Banga has won, with 2539 votes!</h2>
        <p>
            View full election results <a href="http://www.edmonton.ca/city_government/by-election.aspx">here</a>.
        </p>
    </div>

    <div class="flex-justified" style="text-align: center;">
        <div class="column">
            <div class="whitecard">
                <h3>About the By-Election</h3>
                <p>
                    When <a href="{{ URL::route('councillor.show', "A. Sohi - Councillor") }}">Amarjeet Sohi</a> won a
                    seat
                    in the federal election and earned his Infrastructure Minister position on cabinet, a municipal
                    by-election
                    needed to be called to fill his seat on Council. This has quickly become the biggest by-election in
                    Edmonton's history, with over 29 candidates registered to run as of January 13, 2016.
                </p>

                <p>
                    For full information about the by-election, check out of the <a
                            href="http://www.edmonton.ca/city_government/by-election.aspx">City of Edmonton's
                        website</a>
                </p>
                <p>
                    <a href="http://www.edmonton.ca/city_government/by-election.aspx" class="button">Click Here</a>
                </p>
            </div>

        </div>
        <div class="column">
            <div class="whitecard">
                <h3>About YEGVOTES.info</h3>
                <p>
                    <a href="https://yegvotes.info/about">YEGVotes.info</a> is a site run by <a
                            href="http://tpavlek.me">Troy Pavlek</a>.
                    It's chief purpose uses the Edmonton Open Data Catalogue to keep track of City Council voting
                    records.
                    However, during the Ward 12 election, with a staggering number of candidates and no easy way to
                    gather
                    information about all of them it seemed sensible to build a page that allowed for that.
                </p>

                <p>
                    If there is data you want aggregated, or if you notice incorrect data, please let me know through
                    one of
                    the contact options below.
                </p>
                <p>
                    <a href="https://twitter.com/troypavlek" class="button"><i class="fa fa-twitter"></i>
                        Tweet @troypavlek</a>
                    <a href="mailto:troy@tpavlek.me?subject=YEGVotes Ward12 Feedback" class="button"><i
                                class="fa fa-envelope"></i> Email troy@tpavlek.me</a>
                </p>
            </div>
        </div>

    </div>

@stop
