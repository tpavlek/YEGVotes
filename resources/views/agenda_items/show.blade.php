@extends('layout')

@section('content')
    <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-2">
            <h1>
                {{ $agenda_item->meeting->title }}
                <a href="{{ URL::route('meetings.show', $agenda_item->meeting->id) }}" class="button primary small">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </h1>
        </div>
        <div class="pure-u-1 pure-u-md-1-2">
            <h1>Agenda Item:</h1>
            <p>
                {!! $agenda_item !!}
            </p>
        </div>
    </div>

    <h2>Motions</h2>
    <div class="pure-g">
        @forelse ($agenda_item->motions as $motion)
            <div class="pure-u-1 pure-u-md-1-3">
                <div class="motion-summary">
                    {!! $motion !!}
                    <div class="motion-status" style="font-size: 2em;">
                        @if ($motion->status == "Carried")
                            <i class="fa fa-check-square-o"></i> {{ $motion->status }}
                        @elseif ($motion->status == "Failed" || $motion->status == "No Vote")
                            <i class="fa fa-times-circle-o"></i> {{ $motion->status }}
                        @else
                            <i class="fa fa-times-circle-o"></i> No Status
                        @endif
                    </div>
                    @if ($motion->hasVotes())
                        <div>
                            <button class="button vote-toggle">Show Votes</button>
                        </div>
                    @endif

                    <div class="vote-container">
                        <div class="tabular-votes">
                            @if ($motion->votes->groupBy('vote')->get('Yes'))
                                <div class="vote-column Yes">
                                    <h4 class="vote-type">Yes</h4>
                                    @foreach ($motion->votes->groupBy('vote')->get('Yes') as $vote)
                                        <div class="vote">{{ $vote->voter }}</div>
                                    @endforeach
                                </div>
                            @endif

                            @if ($motion->votes->groupBy('vote')->get('No'))
                                <div class="vote-column No">
                                    <h4 class="vote-type">No</h4>
                                    @foreach ($motion->votes->groupBy('vote')->get('No') as $vote)
                                        <div class="vote">{{ $vote->voter }}</div>
                                    @endforeach
                                </div>
                            @endif

                            @if ($motion->votes->groupBy('vote')->get('Abstain'))
                                <div class="vote-column Abstain">
                                    <h4 class="vote-type">Abstain</h4>
                                    @foreach ($motion->votes->groupBy('vote')->get('Abstain') as $vote)
                                        <div class="vote">{{ $vote->voter }}</div>
                                    @endforeach
                                </div>
                            @endif

                            @if ($motion->votes->groupBy('vote')->get('Absent'))
                                <div class="vote-column Absent">
                                    <h4 class="vote-type">Absent</h4>
                                    @foreach ($motion->votes->groupBy('vote')->get('Absent') as $vote)
                                        <div class="vote">{{ $vote->voter }}</div>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="pure-u-1">
                <em>No motions here!</em>
            </div>
        @endforelse
    </div>

    <script>
        $(document).ready(function() {
            $(".vote-toggle").click(function() {
                var button = $(this);
                var voteContainer = $(this).parent().next();
                var motionSummary = $(this).parents('.motion-summary');

                console.log($(this));
                if (voteContainer.is(':visible')) {
                    button.text("Show Votes");
                    motionSummary.removeClass('absolute-motion-summary');
                    voteContainer.slideToggle();
                } else {
                    var width = $(window).width();
                    var fifteenFromLeft = width * 0.15;
                    var currentPosition = motionSummary.position();

                    motionSummary.css("position", "absolute");
                    motionSummary.css("top", currentPosition.top);
                    motionSummary.css("left", currentPosition.left);

                    var leftDifference = currentPosition.left - fifteenFromLeft;

                    motionSummary.animate({
                        width: width * 0.7,
                        left: "-=" + leftDifference
                        //right: "15%",
                    }, 500, function() {
                        button.text("Hide Votes");
                        motionSummary.addClass('absolute-motion-summary');
                        motionSummary.removeAttr('style');
                        voteContainer.slideToggle().css("display", "inline-block");
                    });

                }

            });
        });
    </script>
@stop
