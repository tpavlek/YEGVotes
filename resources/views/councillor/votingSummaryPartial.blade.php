<div class="vote-summary-container">
    @foreach ($voting_items as $voting_item)
        <div class="card vote-summary">
            <div class="card-content">
                <span class="card-title">{{ $voting_item }}</span>
                <a class="btn-floating halfway-fab waves-effect waves-light red" href="{{ URL::route('agenda_item.show', $voting_item->id) }}">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
            @foreach($voting_item->getVoteGroupsForCouncillor($councillor) as $key => $votes)
                <div class="card-content @if ($key == "Yes") green @elseif($key == "No") red darken-4 @else grey darken-3 @endif">
                    <div class="motion-status">
                        @if ($key == "Yes")
                            <i class="fa fa-check-square-o"></i> {{ $key }} ({{ $votes->count() }} votes)
                        @elseif ($key == "No")
                            <i class="fa fa-times-circle-o"></i> {{ $key }} ({{ $votes->count() }} votes)
                        @else
                            <i class="fa fa-times-circle-o"></i> {{ $key }} ({{ $votes->count() }} votes)
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
