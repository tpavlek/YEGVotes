@if ($groupedAgendaItems->get($section_key))
    <div class="card {{ $card_class or "" }}">
        <div class="card-content">
            <span class="card-title section-title">{{ $section_name }}</span>

            @foreach($groupedAgendaItems->get($section_key) as $agenda_item)

                @if ($section_key == \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_REVISED_DUE_DATE)
                    <span>{!! $agenda_item->formattedTitle !!} • </span>
                    <span style="font-weight: bold; color:green;">
                        {{ $agenda_item->revised_due_date->format("F j, Y") }}
                    </span>

                    @if($future_meetings->has($agenda_item->revised_due_date->toDateString()))
                        <a href="{{ URL::route('meetings.show', $future_meetings->get($agenda_item->revised_due_date->toDateString())->id) }}" class="button xsmall">
                            <i class="fa fa-arrow-right fa-sm"></i>
                        </a>
                    @endif

                    <br />

                @else

                    <span>{!! $agenda_item->formattedTitle !!}</span>
                    @if ($agenda_item->hasMotions())
                        <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}" class="button xsmall">
                            <i class="fa fa-arrow-right fa-sm"></i>
                        </a>
                    @endif
                    <br />
                @endif
            @endforeach
        </div>
    </div>
@endif
