<div class="vote-container">
    <div class="tabular-votes">
        @if ($votes->get('Yes'))
            <div class="vote-column Yes">
                <h4 class="vote-type">Yes</h4>
                @foreach ($votes->get('Yes') as $vote)
                    <div class="vote">{{ $vote->voter }}</div>
                @endforeach
            </div>
        @endif

        @if ($votes->get('No'))
            <div class="vote-column No">
                <h4 class="vote-type">No</h4>
                @foreach ($votes->get('No') as $vote)
                    <div class="vote">{{ $vote->voter }}</div>
                @endforeach
            </div>
        @endif

        @if ($votes->get('Abstain'))
            <div class="vote-column Abstain">
                <h4 class="vote-type">Abstain</h4>
                @foreach ($votes->get('Abstain') as $vote)
                    <div class="vote">{{ $vote->voter }}</div>
                @endforeach
            </div>
        @endif

        @if ($votes->get('Absent'))
            <div class="vote-column Absent">
                <h4 class="vote-type">Absent</h4>
                @foreach ($votes->get('Absent') as $vote)
                    <div class="vote">{{ $vote->voter }}</div>
                @endforeach
            </div>
        @endif

    </div>
</div>
