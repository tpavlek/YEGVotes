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
    <a href="{{ URL::route('postable.submit', [ 'candidate' => $candidate->id ]) }}" class="button secondary">Submit Campaign Update</a>
    <div class="flex">
        @include('candidate.candidateDisplayPartial')
            @forelse($postable_content as $content)
            <div class="whitecard">
                <h2>{{ $content->updated_at->format('M j, Y') }}</h2>
                {!! $content->render() !!}
            </div>
            @empty
                <div class="whitecard">
                    <h2>Campaign Posts</h2>
                    <em>Seems as if there's nothing for this candidate yet.</em>
                </div>
            @endforelse

    </div>

@stop
