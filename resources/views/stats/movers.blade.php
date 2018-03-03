@extends('layout')

@section('title', "Which Edmonton City Councillor makes the most motions? -")

@section('meta_description')
    The edmonton city councillor with the most motions is {{ $movers->first()['mover'] }}. The councillor with the most
    seconds is {{ $seconders->first()['seconder'] }}
@stop

@section('content')
    <div class="center">
        <h1>Which Edmonton City Councillor makes the most motions?</h1>

        <div class="flex">
            <div class="flex-item">
                With <strong>{{ $movers->first()['motions'] }}</strong> motions the councillor with the most <strong>motions</strong> is:
                <div class="small-person-details">
                    @include('councilMemberPartial', [ 'attendance_record' => $movers->first()['attendance'] ])
                </div>

                The second-highest councillor is {{ $movers->get(1)['mover'] }} with {{ $movers->get(1)['motions'] }}
            </div>

            <div class="flex-item">
                With <strong>{{ $seconders->first()['motions'] }}</strong> seconds the councillor with the most <strong>seconds</strong> is:
                <div class="small-person-details">
                    @include('councilMemberPartial', [ 'attendance_record' => $seconders->first()['attendance'] ])
                </div>
                The second-highest councillor is {{ $seconders->get(1)['seconder'] }} with {{ $seconders->get(1)['motions'] }}
            </div>
        </div>

        <h2 style="margin-top:4rem; margin-bottom:4rem;">So, why do the top mover and seconder have roughly 5x the number of motions compared to their peers?</h2>

        <div style="display:flex">
            <div style="flex:1">
                When looking at motions to read bylaws, two councillors come up as a mover-seconder power team <em>very often</em>

                In fact, in motions to read bylaws this team moves and seconds

                <div class="large-percentage" style="font-size:25vh;color:dodgerblue;">
                    {{ number_format(($pairings->first()['motions'] / $pairings->sum('motions')) * 100, 0) }}%
                </div>

                of the time.
            </div>
        </div>
    </div>


@stop
