@extends('layout')

@section('content')
    <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-2">
            <h1>
                {{ $motion->meeting->title }}
                <a href="{{ URL::route('meetings.show', $motion->meeting->id) }}" class="button primary small">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </h1>
            <h2>
                {{ $motion->agenda_item }}
                <a href="{{ URL::route('agenda_item.show', $motion->agenda_item->id) }}" class="button primary xsmall">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </h2>
        </div>
        <div class="pure-u-1 pure-u-md-1-2">
            <h1>Motion:</h1>
            <p>
                {!! $motion !!}
            </p>
        </div>
    </div>
    <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-3">
            @if ($motion->mover)
                <div class="mover" style="position:relative;">
                    <div class="motion-label">
                        Mover
                    </div>
                    <div class="small-person-details">
                        @include('councilMemberPartial', [ 'council_member' => $motion->mover ])
                    </div>
                </div>

            @endif
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
            @if($motion->seconder)
                <div class="seconder">
                    <div class="motion-label">
                        Second
                    </div>
                    <div class="small-person-details">
                        @include('councilMemberPartial', [ 'council_member' => $motion->seconder ])
                    </div>
                </div>
            @endif
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
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

    </div>

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
@stop
