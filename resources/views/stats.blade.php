@extends('layout')

@section('title', "Learn about Edmonton City Council -")

@section('meta_description')
    Track statistical information about Edmonton city council like: what types of bylaws does Council vote on? How often
    does council disagree? Who makes the most motions?
@stop



@section('content')
    <style>
        li { padding-top: 0.5rem; padding-bottom: 0.5rem;}
    </style>
    <h1>Some Questions about Council to explore</h1>
    <div style="text-align: left;">
        <ul>
            <li>
                <a href="{{ URL::route('stats.movers') }}">
                    Who makes the most motions/seconds?
                </a>
            </li>
            <li>
                <a href="{{ URL::route('stats.private') }}">
                    How often does Council meet in private?
                </a>
            </li>
            <li>
                <a href="{{ URL::route('stats.speakers') }}">
                    Who speaks to City Council and Committee and how often?
                </a>
            </li>
            <li>
                <a href="{{ URL::route('stats.attendance') }}">
                    How often does City Council attend meetings?
                </a>
            </li>
        </ul>
    </div>

@stop

@section('scripts')
@stop
