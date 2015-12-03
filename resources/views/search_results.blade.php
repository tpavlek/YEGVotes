@extends('layout')

@section('title')
    Search for {{ $term }}
@stop

@section('content')
    @forelse ($results as $agenda_item)
        @include('agendaItemPartial', [ 'agenda_item' => $agenda_item, 'show_meeting' => true ])
    @empty
        <em>No results found for {{ $term }}</em>
    @endforelse


@stop
