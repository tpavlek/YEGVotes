@extends('layout')

@section('title', "$agenda_item -")

@section('content')
    <div>
        <h1>
            {{ $agenda_item->meeting->title }}
            <a href="{{ URL::route('meetings.show', $agenda_item->meeting->id) }}" class="button primary small">
                <i class="fa fa-arrow-right"></i>
            </a>
        </h1>
    </div>
    <div>
        <h1>Agenda Item:</h1>
        <p>
            {!! $agenda_item !!}
        </p>
    </div>

    <h2>Motions</h2>
    <div class="motion-summary-container">
        @forelse ($agenda_item->motions as $motion)
            <div class="motion-summary-wrapper">
                <div class="motion-summary">
                    <p>
                        <a href="{{ URL::route('motion.show', $motion->id) }}" class="button secondary xsmall">
                            View Motion
                        </a>
                    </p>
                    {!! $motion !!}
                    <div class="motion-status smaller">
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
                            <button class="button vote-toggle">
                                <i class="fa fa-expand"></i> <span class="vote-text">Show Votes</span>
                            </button>
                        </div>
                    @endif

                    @include('voteTablePartial', [ 'votes' => $motion->votes->groupBy('vote') ])

                </div>
            </div>
        @empty
            <div>
                <em>No motions here!</em>
            </div>
        @endforelse

    </div>


@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            var bindAnimation = function() {
                var button = $(this);
                var voteContainer = $(this).parent().next();
                var motionSummary = $(this).parents('.motion-summary');

                if (voteContainer.is(':visible')) {
                    var originalMotionSummary = $(this).parents('.motion-summary-container').find('.motion-summary:not(".duplicate")');
                    console.log(originalMotionSummary);


                    var widthDifference = motionSummary.width() - originalMotionSummary.width();
                    motionSummary.animate({
                        height: "-=" + motionSummary.height(),
                        width: "-=" + widthDifference,
                        left: "+=" + (widthDifference / 2),
                        right: "+=" + (widthDifference / 2)
                    }, 500, "swing", function() {
                        motionSummary.remove();
                        originalMotionSummary.css("display", "block");
                    });
                } else {
                    var width = $(window).width();
                    var fifteenFromLeft = width * 0.15;
                    var newWidth = width * 0.7;

                    if (width < 1024) {
                        // If the screen is less than 1024 wide, we make the modal 90% of width instead of 70%
                        fifteenFromLeft = width * 0.05;
                        newWidth = width * 0.9;
                    }
                    var currentPosition = motionSummary.position();

                    var newMotionSummary = motionSummary.clone().addClass('duplicate').appendTo(motionSummary.parent());
                    $(".vote-toggle").unbind("click");
                    $(".vote-toggle").click(bindAnimation);
                    motionSummary.css("display", "none");
                    newMotionSummary.css("position", "absolute");
                    newMotionSummary.css("top", currentPosition.top);
                    newMotionSummary.css("left", currentPosition.left);

                    var leftDifference = currentPosition.left - fifteenFromLeft;

                    newMotionSummary.animate({
                        width: newWidth,
                        left: "-=" + leftDifference
                    }, 500, function() {
                        newMotionSummary.find('.vote-toggle .vote-text').html("Hide Votes");
                        newMotionSummary.addClass('absolute-motion-summary');
                        newMotionSummary.removeAttr('style');
                        newMotionSummary.find('.vote-container').slideToggle().css("display", "inline-block");
                    });

                }

            };

            $(".vote-toggle").click(bindAnimation);
        });
    </script>
@stop
