@extends('layout')

@section('title', "$agenda_item -")

@section('content')

    <div class="motions">
        @forelse ($agenda_item->motions as $motion)
            @include('motion.motion_card', [ 'motion' => $motion, 'votes' => $motion->votes->groupBy('vote') ])
        @empty
            <div>
                <em>No motions here!</em>
            </div>
        @endforelse

    </div>


@stop
