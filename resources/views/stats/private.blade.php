@extends('layout')

@section('title')
    How often does Edmonton City Council meet in Private?
@stop

@section('meta_description')
    TODO
@stop

@section('content')
    <h1 style="margin-bottom:3rem;">How often does Edmonton City Council meet in private?</h1>

    In <strong>{{ $privateMeetings->count() }}</strong> of {{ $totalMeetings }} total council/committee, council voted to
    meet in private.

    <div style="display:flex">
        <div style="flex-grow:1">
            With <strong>{{ $movers->first()['motions'] }}</strong> motions the councillor with the most <strong>motions</strong> is:
            <div class="small-person-details">
                @include('councilMemberPartial', [ 'council_member' => $movers->first()['mover'], 'link' => true ])
            </div>

            The second-highest councillor is {{ $movers->get(1)['mover'] }} with {{ $movers->get(1)['motions'] }}
        </div>

        <div style="flex-grow:1">
            With <strong>{{ $seconders->first()['motions'] }}</strong> seconds the councillor with the most <strong>seconds</strong> is:
            <div class="small-person-details">
                @include('councilMemberPartial', [ 'council_member' => $seconders->first()['seconder'], 'link' => true ])
            </div>
            The second-highest councillor is {{ $seconders->get(1)['seconder'] }} with {{ $seconders->get(1)['motions'] }}
        </div>
    </div>

    <h2 style="margin-top:4rem; margin-bottom:4rem;">So, why do the top mover and seconder have roughly 5x the number of motions compared to their peers?</h2>

    <div style="display:flex">
        <div style="flex:1">
            When looking at motions to read bylaws, two councillors come up as a mover-seconder power team <em>very often</em>
            <div>
                <div class="small-person-details" style="display:inline-block;">
                    @include('councilMemberPartial', [ 'council_member' => $pairings->first()['mover'], 'link' => true ])
                </div>
                <div class="small-person-details" style="display:inline-block;">
                    @include('councilMemberPartial', [ 'council_member' => $pairings->first()['seconder'], 'link' => true ])
                </div>
            </div>


            In fact, in motions to read bylaws this team moves and seconds

            <div class="large-percentage" style="font-size:25vh;color:dodgerblue;">
                {{ number_format(($pairings->first()['motions'] / $pairings->sum('motions')) * 100, 0) }}%
            </div>

            of the time.
        </div>
    </div>

@stop
