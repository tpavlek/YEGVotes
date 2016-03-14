<div class="item-container">
    <header class="agenda-item-topic">
        {{ $agenda_item }}
        @if (isset($show_meeting) && $show_meeting)
            <a href="{{ URL::route('meetings.show', $agenda_item->meeting->id) }}">
                <small><br/>{{ $agenda_item->meeting }}</small>
            </a>
        @endif
    </header>
    <h4>Motions:</h4>
    <div class="motions">
        @foreach ($agenda_item->motions as $index => $motion)
            <div class="motion {{ $motion->getIndicatorString() }}">
                <div class="motion-indicator">
                    <input type="checkbox" name="tabs" id="motion{{$motion->id}}" @if ($index == 0 && isset($checkFirst) && $checkFirst) checked @endif />
                    <label for="motion{{$motion->id}}">
                        @if ($motion->getIndicatorString() == "Failed")
                            <i class="fa fa-times-circle"></i>
                        @elseif($motion->getIndicatorString() == "Unanimous")
                            <i class="fa fa-check-circle"></i>
                        @elseif($motion->getIndicatorString() == "Disagreement")
                            <i class="fa fa-exclamation-circle"></i>
                        @else
                            <i class="fa fa-info-circle"></i>
                        @endif
                    </label>
                    <div id="motion-content{{$motion->id}}" class="motion-content">
                        <a href="{{ URL::route('motion.show', $motion->id) }}" class="button small secondary">
                            Show Motion
                        </a>
                        <p>
                            {!! $motion !!}
                        </p>
                        @include('voteTablePartial', [ 'votes' => $motion->votes->groupBy('vote') ])
                    </div>

                </div>
            </div>
        @endforeach
    </div>
    <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}" class="button small">
        <i class="fa fa-eye"></i> View Agenda
    </a>
</div>
