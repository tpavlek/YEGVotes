@extends('layout')

@section('title')
    Ward {{ $ward_number }} Candidates - {{ $election->name }}
@stop

@section('content')

    <h1>{{ $election->name }} <small style="color:goldenrod">Ward {{ $ward_number }}</small></h1>
    <div class="whitecard">
        <h2>You're viewing the candidates in Ward {{ $ward_number }}</h2>
        <p>
            <a href="{{ URL::route('elections.show', $election->id) }}" class="button"><i class="fa fa-arrow-left"></i> View Election</a>.
        </p>
    </div>

    <div class="flex-justified">

        @forelse($candidates as $candidate)
            @include('candidate.candidateDisplayPartial')
        @empty
            <em>There doesn't seem to be anyone declared yet!</em>
        @endforelse



    </div>



@stop
