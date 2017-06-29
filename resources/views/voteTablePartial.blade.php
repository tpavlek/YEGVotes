@if (isset($display_votes) && !$display_votes && !$motion->hasDissent())
    <a class="waves-effect waves-light btn vote-display-button"><i class="fa fa-expand"></i> Show Votes</a>
@endif

@if($motion->isUnanimous())
    <p>
        <span class="unanimous-status vote-status"><i class="fa fa-check"></i> Unanimous</span>
    </p>
@else

    <div class="vote-container" @if (isset($display_votes) && !$display_votes) style="display:none;" @endif>
        <div class="tabular-votes">
            @if ($votes->get('Yes'))
                <div class="vote-column Yes">
                    <h4 class="vote-type">Yes</h4>
                    @foreach ($votes->get('Yes') as $vote)
                        <div class="vote">
                            <a href="{{ URL::route('councillor.show', $vote->voter) }}">{{ $vote->voter }}</a>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($votes->get('No'))
                <div class="vote-column No">
                    <h4 class="vote-type">No</h4>
                    @foreach ($votes->get('No') as $vote)
                        <div class="vote">
                            <a href="{{ URL::route('councillor.show', $vote->voter) }}">{{ $vote->voter }}</a>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($votes->get('Abstain'))
                <div class="vote-column Abstain">
                    <h4 class="vote-type">Abstain</h4>
                    @foreach ($votes->get('Abstain') as $vote)
                        <div class="vote">
                            <a href="{{ URL::route('councillor.show', $vote->voter) }}">{{ $vote->voter }}</a>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($votes->get('Absent'))
                <div class="vote-column Absent">
                    <h4 class="vote-type">Absent</h4>
                    @foreach ($votes->get('Absent') as $vote)
                        <div class="vote">
                            <a href="{{ URL::route('councillor.show', $vote->voter) }}">{{ $vote->voter }}</a>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
@endif

@section('scripts')

<script>
    $('.vote-display-button').click(function() {
        $(this).siblings().filter('.vote-container').show('fast');
        $(this).hide('fast');
    })
</script>

@stop
