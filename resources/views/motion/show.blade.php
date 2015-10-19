@extends('layout')

@section('content')
    <h2>{{ $motion->meeting->meeting_type }} {{ $motion->meeting->date->toDateString() }}: {{ $motion->agenda_item }}</h2>

    <h3>Motion: {{ strip_tags($motion) }}</h3>
    @if ($motion->mover)
        <div class="mover">
            Mover:
            <div class="small-person-details">
                @include('councilMemberPartial', [ 'council_member' => $motion->mover ])
            </div>
        </div>

    @endif
    @if($motion->seconder)
        <div class="seconder">
            Seconder:
            <div class="small-person-details">
                @include('councilMemberPartial', [ 'council_member' => $motion->seconder ])
            </div>
        </div>
    @endif

    <h2>Motion was: {{ $motion->status }}</h2>
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
