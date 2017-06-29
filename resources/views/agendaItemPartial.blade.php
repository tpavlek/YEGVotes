<div class="item-container">
    <div class="motion-summary-container">
        <div class="card vote-summary">
            <div class="card-content">
                <span class="card-title">{{ $agenda_item }}</span>
                <a class="btn-floating halfway-fab waves-effect waves-light red" href="{{ URL::route('agenda_item.show', $agenda_item->id) }}">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
            @foreach($agenda_item->motions as $motion)
                <div class="card-content @if ($motion->status == "Carried") green @elseif($motion->status == "Failed") red darken-4 @else grey darken-3 @endif white-text">
                    <div class="motion-status">
                        @if ($motion->status == "Carried")
                            <i class="fa fa-check-square-o"></i> {{ $motion->status }} ({{ $motion->voteSummary() }})
                        @elseif ($key == "No")
                            <i class="fa fa-times-circle-o"></i> {{ $key }} ({{ $votes->count() }} votes)
                        @else
                            <i class="fa fa-times-circle-o"></i> {{ $key }} ({{ $votes->count() }} votes)
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
