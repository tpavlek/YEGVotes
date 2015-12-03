@extends('layout')

@section('title')
    Learn about Edmonton City Council
@stop

@section('meta_description')
    Track statistical information about Edmonton city council like: what types of bylaws does Council vote on? How often
    does council disagree? Who makes the most motions?
@stop

@section('content')
    <h1>Some Questions about Council to explore</h1>
    <div style="text-align: left;">
        <ul>
            <li>
                <a href="{{ URL::route('stats.movers') }}">
                    Who makes the most motions/seconds?
                </a>
            </li>
        </ul>
    </div>

@stop

@section('scripts')
@stop
