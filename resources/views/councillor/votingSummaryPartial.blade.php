<div class="vote-container" style="margin-top: 0;">
    @foreach ($voting_items as $voting_item)
        <div class="vote" data-remote-url="{{ URL::route('agenda_item.show', $voting_item->id) }}">
            <div class="vote-summary">
                <div class="short-title">
                    {{ $voting_item }}
                </div>
            </div>

            <div class="sub-votes">
                @foreach ($voting_item->getVoteGroupsForCouncillor($councillor) as $key => $votes)
                    <span class="vote {{ $key }}" style="flex-grow:{{ $votes->count() }}">
                        {{ $key }}: {{ $votes->count() }}
                    </span>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
