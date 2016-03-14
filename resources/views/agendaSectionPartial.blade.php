@if ($groupedAgendaItems->get($section_key))
    <div class="whitecard {{ $card_class or "" }}">
        <h2>{{ $section_name }}</h2>

        @foreach($groupedAgendaItems->get($section_key) as $agenda_item)

            <span>{!! $agenda_item->formattedTitle !!}</span>
            @if ($agenda_item->hasVotes())
                <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}" class="button xsmall">
                    <i class="fa fa-arrow-right fa-sm"></i>
                </a>
            @endif
            <br />
        @endforeach
    </div>
@endif
