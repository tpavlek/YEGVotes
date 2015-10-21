@extends('layout')

@section('content')
    <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-2">
            <h1>
                {{ $agenda_item->meeting->title }}
                <a href="{{ URL::route('meetings.show', $agenda_item->meeting->id) }}" class="button primary small">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </h1>
        </div>
        <div class="pure-u-1 pure-u-md-1-2">
            <h1>Agenda Item:</h1>
            <p>
                {!! $agenda_item !!}
            </p>
        </div>
    </div>
    <div class="pure-g">
        <div class="pure-u-1">
            <h2>Motions</h2>
        </div>

        @forelse ($agenda_item->motions as $motion)

            <div class="pure-u-1 pure-u-md-1-3">
                {{ $motion }}
                <div class="motion-status" style="font-size: 2em;">
                    @if ($motion->status == "Carried")
                        <i class="fa fa-check-square-o"></i> {{ $motion->status }}
                    @elseif ($motion->status == "Failed" || $motion->status == "No Vote")
                        <i class="fa fa-times-circle-o"></i> {{ $motion->status }}
                    @else
                        <i class="fa fa-times-circle-o"></i> No Status
                    @endif
                </div>

                <div>
                    Votes 12/13
                </div>
            </div>
        @empty
                <em>No motions here!</em>
        @endforelse




    </div>

@stop
