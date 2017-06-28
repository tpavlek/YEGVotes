@extends('layout')

@section('title', "All speakers at Edmonton City Council -")

@section('content')
    <div class="whitecard" style="display: inline-block; width: 700px">
        <style>
            table {
                margin: 0 auto;
                margin-top: 2rem;
                text-align: left;
            }
            td {
                padding: 0.5rem;
                padding-right: 2rem;
            }
        </style>
        <table>
            <thead>
            <tr>
                <th>Speaker</th>
                <th># of Times Speaking</th>
            </tr>
            </thead>
            <tbody>
            @foreach($speakers as $speaker => $count)
                <tr>
                    <td>
                        <a href="{{ URL::route('speakers.show', $speaker) }}">{{ $speaker }}</a>
                    </td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
