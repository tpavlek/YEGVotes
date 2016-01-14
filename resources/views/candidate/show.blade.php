@extends('layout')

@section('title')
    - {{ $candidate->full_name }} running in {{ $candidate->election->name }}
@stop

@section('content')
    <div class="notification whitecard">
        <h2>Note!</h2>
        <p>
            {{ $candidate->full_name }} is running in <a href="{{ URL::route('elections.show', $candidate->election->id) }}">{{ $candidate->election->name }}</a>.
        You can view the other candidates running in the same race by clicking the button below.
        </p>
        <a href="{{ URL::route('elections.show', $candidate->election->id) }}" class="button">View {{ $candidate->election->name }}</a>

    </div>
    <h1>{{ $candidate->running_name }}</h1>
    <div class="flex">
        @include('candidate.candidateDisplayPartial')
    </div>

@stop
