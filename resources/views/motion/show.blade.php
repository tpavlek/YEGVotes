@extends('layout')

@section('title', "View Motion -")

@section('content')

    @include('motion.motion_card', [ 'motion' => $motion ])

@stop
