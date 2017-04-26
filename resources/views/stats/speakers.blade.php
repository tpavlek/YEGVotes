@extends('layout')

@section('title')
    How many people speak at City Council each year? -
@stop

@section('meta_image', '/img/speakers.png')

@section('meta_description')
    Last year {{ $speakersByYear->get(\Carbon\Carbon::now()->subYear()->year)->count() }} people spoke at Edmonton City Council or Committee meetings.
@stop

@section('content')
    <h1 style="margin-bottom:3rem;">How many people speak at City Council each year?</h1>
    <div class="whitecard" style="display: inline-block">
        <canvas id="participation-chart" width="700px" style="max-width: 700px; margin: 0 auto;"></canvas>

        <p>
            So far, this year, <strong>{{ $speakersByYear->get(\Carbon\Carbon::now()->year)->count() }}</strong> speakers have spoken at council and committee.
        </p>
    </div>


    <h2>Speakers this term, by committee</h2>

    <div class="whitecard" style="display: inline-block;">
        <canvas id="by-committee" width="700px" style="max-width: 700px; margin: 0 auto;"></canvas>
    </div>

    <h2>Who speaks most often?</h2>
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
            @foreach($topSpeakers as $speaker => $count)
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

@section('scripts')
    <script src="/scripts/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("participation-chart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [ {{ $speakersByYear->keys()->implode(',') }} ],
                datasets: [{
                    label: 'Speakers at Council/Committee',
                    data: [ {{ $speakersByYear->map(function ($group) { return $group->count(); })->implode(',') }} ],
                    fill: false,
                    backgroundColor: "rgba(211, 88, 82, 0.4)",
                    borderColor: "rgba(216, 54, 54,1)"
                }]
            },
            options: {
            }
        });

        var byCommittee = document.getElementById("by-committee");
        var byCommitteeChart = new Chart(byCommittee, {
            type: 'doughnut',
            data: {
                labels: [ {!! $speakersByCommittee->keys()->map(function ($key) { return "\"$key\""; })->implode(',') !!} ],
                datasets: [{
                    label: 'Speakers at Council/Committee',
                    data: [ {{ $speakersByCommittee->implode(',') }} ],
                    fill: false,
                    backgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                        "#FFCE56",
                        "#66a020",
                        "#601099",
                        "#a5350d",
                        "#0a0faa",
                        "#ed8642"
                    ]
                }]
            },
            options: {
            }
        });

    </script>
@stop
