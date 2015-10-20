@extends('layout')

@section('content')
    <h2>{{ $motion->meeting->meeting_type }} {{ $motion->meeting->date->toDateString() }}: {{ $motion->agenda_item }}</h2>

    <h3>Motion: {{ strip_tags($motion) }}</h3>
    <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-3">
            @if ($motion->mover)
                <div class="mover">
                    <div class="small-person-details">
                        @include('councilMemberPartial', [ 'council_member' => $motion->mover ])
                    </div>
                </div>

            @endif
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
            @if($motion->seconder)
                <div class="seconder">
                    <div class="small-person-details">
                        @include('councilMemberPartial', [ 'council_member' => $motion->seconder ])
                    </div>
                </div>
            @endif
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
            @if ($motion->status == "Carried")
                <div class="motion-status">
                    <i class="fa-check-square-o fa-2x"></i> {{ $motion->status }}
                </div>
            @elseif ($motion->status == "Failed")
            @elseif ($motion->status == "No Vote")
            @else
            @endif
            <h2>Motion was: {{ $motion->status }}</h2>
        </div>

    </div>


    <h3>Votes</h3>
    <div>
        @if ($votes->get('Yes'))
        <h4>Yes</h4>
            @foreach ($votes->get('Yes') as $vote)
                <div class="vote">{{ $vote->voter }}</div>
            @endforeach
        @endif

        @if ($votes->get('No'))
            <h4>No</h4>
            @foreach ($votes->get('No') as $vote)
                <div class="vote">{{ $vote->voter }}</div>
            @endforeach
        @endif

        @if ($votes->get('Abstain'))
            <h4>Abstain</h4>
            @foreach ($votes->get('Abstain') as $vote)
                <div class="vote">{{ $vote->voter }}</div>
            @endforeach
        @endif

        @if ($votes->get('Absent'))
            <h4>Absent</h4>
            @foreach ($votes->get('Absent') as $vote)
                <div class="vote">{{ $vote->voter }}</div>
            @endforeach
        @endif


    </div>

    <table class="voting-table">
        <thead>
            <tr>
                <th>Council Member</th>
                <th>Vote</th>
            </tr>
            @foreach($motion->votes as $vote)
                <tr>
                    <td>{{ $vote->voter }}</td>
                    <td class="vote {{ $vote->vote }}">{{ $vote }}</td>
                </tr>
            @endforeach
        </thead>
    </table>
@stop
