@if ($groupedAgendaItems->get($section_key))
    <div class="card {{ $card_class or "" }}">
        <div class="card-content">
            <span class="card-title">{{ $section_name }}</span>


        @foreach($groupedAgendaItems->get($section_key) as $agenda_item)

            @if ($agenda_item->hasVotes())
                @if ($agenda_item->isUnanimous())
                    <p>
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
    </div>
@endif
