@if ($groupedAgendaItems->get($section_key))
    <div class="whitecard {{ $card_class or "" }}">
        <h2>{{ $section_name }}</h2>

        @foreach($groupedAgendaItems->get($section_key) as $agenda_item)

            @if ($agenda_item->hasVotes())
                @if ($agenda_item->isUnanimous())
                    <p style="text-align:left;">
                        <span class="item-title">{!! $agenda_item->formattedTitle !!}</span>
                        <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}" class="button xsmall"><i class="fa fa-arrow-right fa-sm"></i></a>

                        <span class="unanimous-status vote-status"><i class="fa fa-check"></i> Unanimous</span>
                    </p>

                @else
                    @include('agendaItemPartial')
                @endif
            @else
                <p style="text-align:left;">
                    <span class="item-title">{!! $agenda_item->formattedTitle !!}</span>
                    <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}" class="button xsmall"><i class="fa fa-arrow-right fa-sm"></i></a>
                </p>
            @endif
        @endforeach

    </div>
@endif
