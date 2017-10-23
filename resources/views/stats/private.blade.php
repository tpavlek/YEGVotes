@extends('layout')

@section('title', "How often does Edmonton City Council meet in Private? -")

@section('meta_image', '/img/speakers.png')

@section('meta_description')
    Edmonton City Council has a private component in {{ number_format(($private_meetings->count() / $total_meetings) * 100, 0) }}% of meetings.
    The most-often cited FOIP section for these private meetings and documents is FOIP section {{ $sections->keys()->first() }}
@stop

@section('content')
    <div class="center">

    <h1>How often does Edmonton City Council meet in private?</h1>

    In <strong>{{ $private_meetings->count() }}</strong> of {{ $total_meetings }} total council/committee, council voted to
    meet in private. That means that the number of meetings that have a private component is:

    <div class="large-percentage" style="font-size:25vh;color:dodgerblue;">
        {{ number_format(($private_meetings->count() / $total_meetings) * 100, 0) }}%
    </div>

    <div>
        <h2>The most often cited section of FOIP is Section {{ $sections->keys()->first() }}</h2>
        <p>
            <em>You may click on any section of this pie chart to get an overview of that FOIP section</em>
        </p>
        <canvas id="sections" style="max-height:60vh"></canvas>

        @include('stats.foip-sections')
    </div>

    <hr />

    <div>
        <h2>On average, there are {{ round($per_month->sum() / $per_month->count()) }} private meetings or confidential documents per month</h2>
        <canvas id="motions" style="max-height:60vh"></canvas>
    </div>

    <h2>These most frequently occurred during <span style="font-weight: 900">{{ $private_meeting_types->keys()->first() }}</span> ({{ $private_meeting_types->first() }} meetings) ({{$all_meeting_types->get($private_meeting_types->keys()->first())}} total)</h2>
    <table>
        <thead>
        <tr>
            <th>Meeting Type</th>
            <th># of Meetings</th>
        </tr>
        </thead>
        <tbody>
        @foreach($private_meeting_types->slice(1) as $meeting_type => $num_meetings)
            <tr>
                <td>{{ $meeting_type }}</td>
                <td>{{ $num_meetings }} / {{$all_meeting_types->get($meeting_type) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <hr />
    <br />


    <div style="display:flex">
        <div style="flex-grow:1">
            With <strong>{{ $movers->first() }}</strong> motions <strong>{{ $movers->keys()->first() }}</strong> moves to meet in private and keep reports private
            the most.
            @include('councilMemberPartial', [ 'council_member' => new \App\Model\CouncilMember($movers->keys()->first()), 'link' => true ])

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
                        <th>Councillor</th>
                        <th># of Motions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movers->slice(1) as $mover => $num_motions)
                        <tr>
                            <td>{{ $mover }}</td>
                            <td>{{ $num_motions }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <br />
    <hr />
    <br />

    <div class="footnote" style="font-size:90%; max-width: 60em; margin: 0 auto;">
        <p><em>How was this calculated?</em></p>
        <p>
            The open data catalogue was used to pull all motions, agenda items and meetings from the Open Data Catalogue.
            A meeting was determined to be in private if it met either of two criteria: there was a vote to meet in private
            that was carried (<em>note: there has <strong>never</strong> been a motion to meet in private that was not carried</em>)
            or there was a private report in which a vote was carried to have the report remain private.
        </p>
        <p>
            Due to the text-based nature of the data in the open data catalogue, this data is presented as best-effort and mistakes
            are endeavoured to be corrected, however there may be slight issues with source data integrity and some of the calculations.
            If anything is noticed to be suspect, please reach out as soon as possible!
        </p>
    </div>
    </div>

@stop

@section('scripts')
    <script src="/scripts/Chart.min.js"></script>
    <script>

        var ctz = document.getElementById("sections");
        var sections = new Chart(ctz, {
            type: 'pie',
            data: {
                labels: section_labels,
                datasets: [{
                    data: section_data,
                    backgroundColor: section_fills,
                    borderColor: section_borders,
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false
            }
        });

        document.getElementById("sections").onclick = function(evt)
        {
            var activePoints = sections.getElementsAtEvent(evt);

            if(activePoints.length > 0)
            {
                //get the internal index of slice in pie chart
                var clickedElementindex = activePoints[0]["_index"];

                //get specific label by index
                var label = sections.data.labels[clickedElementindex];

                //get value by index
                var value = sections.data.datasets[0].data[clickedElementindex];

                $('.foip-section').hide('fast');
                var newElement = $('[data-foip-number="' + label + '"]');
                if (newElement.length == 0) {
                    $('[data-foip-number="unknown"]').show('fast');
                } else {
                    newElement.show('fast');
                }
            }
        };

        var ctx = document.getElementById("motions");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '# of Votes',
                    data: data,
                    backgroundColor: fills,
                    borderColor: borders,
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false
            }
        });
    </script>
@stop
