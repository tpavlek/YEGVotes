<div class="vote-container" style="margin-top: 0;">
    @foreach ($voting_items as $voting_item)
        <div class="pure-g">
            <div class="vote">
                <div class="vote-summary">
                    <div class="pure-u-4-5">
                        <div class="short-title" data-remote-url="{{ URL::route('agenda_item.show', $voting_item->id) }}">
                            {{ $voting_item }}
                        </div>
                    </div>

                    @if ($voting_item->interestingMotions()->count() > 1)
                        <div class="pure-u-1-5">
                            <span class="vote motion-list">
                                <span class="motion-list-label">Motions:</span>
                                <span class=motion-list-count">{{ $voting_item->motions->count() }}</span>
                            </span>
                        </div>
                    @else
                        <div class="pure-u-1-5">
                            <span class="vote {{ $voting_item->interestingMotions()->first()->vote($attendanceRecord->getAttendee()) }}"
                                  data-remote-url="{{ URL::route('motion.show', $voting_item->motion->id) }}">
                                {{ $voting_item->vote($attendanceRecord->getAttendee()) }}
                            </span>
                        </div>
                    @endif

                </div>

                @if ($voting_item->interestingMotions()->count() > 1)
                    <div class="sub-votes">
                        @foreach ($voting_item->interestingMotions() as $motion)
                            <div class="pure-u-1-5">
                                <span class="vote {{ $motion->vote($attendanceRecord->getAttendee()) }}"
                                      data-remote-url="{{ URL::route('motion.show', $motion->id) }}">
                                    {{ $motion->vote($attendanceRecord->getAttendee()) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>


    @endforeach
</div>
