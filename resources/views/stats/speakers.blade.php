@extends('layout')

@section('title', "How many people speak at City Council each year? -")

@section('meta_image', '/img/speakers.png')

@section('meta_description')
    Last year {{ $speakersByYear->get(\Carbon\Carbon::now()->subYear()->year)->count() }} people spoke at Edmonton City Council or Committee meetings.
@stop

@section('content')


    <div class="center">
        <h1>How many people speak at City Council each year?</h1>

        <div class="card" style="display: inline-block; margin: 0 auto;">
            <div class="card-content center">
                <canvas id="participation-chart" width="700px" style="max-width: 700px; margin: 0 auto;"></canvas>

                <p>
                    So far, this year, <strong>{{ $speakersByYear->get(\Carbon\Carbon::now()->year)->count() }}</strong> speakers have spoken at council and committee.
                </p>
            </div>

        </div>

        <div></div>

        <div class="card inline auto-margin">
            <div class="card-content">
                <span class="card-title">
                    Speakers this term, by committee
                </span>

                <canvas id="by-committee" width="700px" style="max-width: 700px; margin: 0 auto;"></canvas>
            </div>
        </div>

        <div></div>


        <div class="card inline auto-margin">
            <div class="card-content">
                <span class="card-title">
                    Who speaks most often?
                </span>

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
            <div class="card-action">
                <a href="{{ URL::route('speakers.list') }}">View Full List</a>
            </div>
        </div>

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
