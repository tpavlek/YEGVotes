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
            @include('motion.motion_card', [ 'motion' => $motion, 'votes' => $motion->votes->groupBy('vote'), 'display_votes' => false ])
        @endforeach
    </div>
    <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}" class="button small">
        <i class="fa fa-eye"></i> View Agenda
    </a>
</div>
