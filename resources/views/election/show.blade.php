@extends('layout')

@section('title')
    Edmonton Ward 12 By-Election
@stop

@section('content')

    <h1>Edmonton Ward 12 By-Election <small style="color:goldenrod">{{ $election_date->format('M j, Y') }}</small></h1>
    <h2>{{ \Carbon\Carbon::now()->diffInDays($election_date) }} days away</h2>

    <div class="flex" style="text-align: center;">
        <div class="column">
            <div class="whitecard">
                <h3>About the By-Election</h3>
                <p>
                    When <a href="{{ URL::route('councillor.show', "A. Sohi - Councillor") }}">Amajeet Sohi</a> won a seat
                    in the federal election and earned his Infrastructure Minister position on cabinet, a municipal by-election
                    needed to be called to fill his seat on Council. This has quickly become the biggest by-election in
                    Edmonton's history, with over 29 candidates registered to run as of January 13, 2016.
                </p>

                <p>
                    For full information about the by-election, check out of the <a href="http://www.edmonton.ca/city_government/by-election.aspx">City of Edmonton's website</a>
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
                    <a href="https://yegvotes.info/about">YEGVotes.info</a> is a site run by <a href="http://tpavlek.me">Troy Pavlek</a>.
                    It's chief purpose uses the Edmonton Open Data Catalogue to keep track of City Council voting records.
                    However, during the Ward 12 election, with a staggering number of candidates and no easy way to gather
                    information about all of them it seemed sensible to build a page that allowed for that.
                </p>

                <p>
                    If there is data you want aggregated, or if you notice incorrect data, please let me know through one of
                    the contact options below.
                </p>
                <p>
                    <a href="https://twitter.com/troypavlek" class="button"><i class="fa fa-twitter"></i> Tweet @troypavlek</a>
                    <a href="mailto:troy@tpavlek.me?subject=YEGVotes Ward12 Feedback" class="button"><i class="fa fa-envelope"></i> Email troy@tpavlek.me</a>
                </p>
                <h4>Planned Features</h4>
                <ul>
                    <li>Candidate landing pages with important information from campaign (tweets, news articles, etc.)</li>
                    <li>Global information feed from all candidates to follow the entire election</li>
                    <li>Voting to rank current frontrunners and reduce visibility for non-serious candidates</li>
                </ul>
                <p>

                </p>
            </div>
        </div>


            @foreach($candidates as $candidate)
                <div class="whitecard candidate">
                    <a href="{{ URL::route('candidate.show', $candidate->id) }}">
                        <div class="candidate-image-container">
                            <img class="candidate-image" src="{{ $candidate->img_url }}" />
                        </div>
                        <h3>{{ $candidate->running_name }}</h3>
                    </a>

                    @if($candidate->facebook)
                        <a class="media-link" href="https://facebook.com/{{$candidate->facebook}}" title="Facebook"><i class="fa fa-2x fa-facebook-official"></i></a>
                    @endif
                    @if($candidate->twitter)
                        <a class="media-link" href="https://twitter.com/{{$candidate->twitter}}" title="Twitter"><i class="fa fa-2x fa-twitter"></i></a>
                    @endif
                    @if ($candidate->website)
                        <a class="media-link" href="{{ $candidate->website }}" title="Website"><i class="fa fa-2x fa-link"></i></a>
                    @endif

                    <p>
                        <strong>Email</strong>:
                        @if ($candidate->email)
                            <a href="mailto:{{$candidate->email}}">{{$candidate->email}}</a>
                        @else
                            <em>Not Provided</em>
                        @endif
                        <br />
                        <br />
                        <strong>Phone:</strong>
                        @if ($candidate->phone)
                            {{ $candidate->phone }}
                        @else
                            <em>Not Provided</em>
                        @endif

                    </p>

                </div>
            @endforeach



    </div>



@stop

@section('scripts')
    <!--script>
        var widthIncrement = 100;
        var heightIncrement = 50;

        $('.candidate').on('mouseenter', function() {
            console.log($(this).height() + heightIncrement + "px");
            $(this).animate({
                width: $(this).width() + widthIncrement + "px",
                height: $(this).height() + heightIncrement + "px"
            }, 100);
        });
        $('.candidate').on('mouseleave', function() {
            // 36 is a magic number and I'm not sure why. Fix it later.
            $(this).animate({
                width: $(this).width() - 36 + "px",
                height: $(this).height() + 14 + "px"
            }, 100);
        })
    </script>-->
@stop
