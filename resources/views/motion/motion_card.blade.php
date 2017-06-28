<div class="motion card white">
    <div class="card-content @if ($motion->status == "Carried") green @endif @if($motion->status == "Failed") red darken-4 @endif white-text">
        <span class="card-title white-text">
            {{ $motion->meeting }}
            <a href="{{ URL::route('meetings.show', $motion->meeting->id) }}" class="white-text">
                <i class="fa fa-arrow-right"></i>
            </a>
        </span>
        <span class="card-title white-text">
            {{ $motion->agenda_item }}
            <a href="{{ URL::route('agenda_item.show', $motion->agenda_item->id) }}" class="white-text">
                <i class="fa fa-arrow-right"></i>
            </a>
        </span>

        <div class="motion-status">
            @if ($motion->status == "Carried")
                <i class="fa fa-check-square-o"></i> {{ $motion->status }}
            @elseif ($motion->status == "Failed" || $motion->status == "No Vote")
                <i class="fa fa-times-circle-o"></i> {{ $motion->status }}
            @else
                <i class="fa fa-times-circle-o"></i> No Status
            @endif
        </div>
    </div>
    <div class="card-action blue-grey darken-1">
        @if ($motion->mover)
            <div class="mover">

                <span class="motion-label">Mover</span>
                <a href="{{ URL::route('councillor.show', (string)$motion->mover) }}">{{ $motion->mover }}</a>
            </div>
        @endif

        @if ($motion->seconder)
            <div class="mover">
                <span class="motion-label">Second</span>
                <a href="{{ URL::route('councillor.show', (string)$motion->seconder) }}">{{ $motion->seconder }}</a>
            </div>

        @endif
    </div>
    <div class="card-content white">

        <p>
            {!! $motion->description !!}
        </p>

    </div>

    <div class="card-content white">
        @include('voteTablePartial', [ 'votes' => $votes, 'display_votes' => $display_votes ?? true ])
    </div>
</div>

