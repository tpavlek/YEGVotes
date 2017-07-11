@extends('layout')

@section('title', "View Motion -")

@section('content')

    @foreach($motions as $motion)
        @include('motion.motion_card', [ 'motion' => $motion ])
    @endforeach

@stop
