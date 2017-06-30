@extends('layout')

@section('title', "How often do Edmonton City Councillors skip meetings? -")

@section('meta_description')
    At a {{ $skipped_meetings->keys()->first() }} there is a {{ $skipped_meetings->first()['percentage'] }}% chance of a councillor being absent
@stop

@section('content')
    <div class="center">
        <h1>How often do Edmonton City Councillors attend meetings?</h1>

        <div class="flex row-wrap">
            <div class="flex-item">
                @include('councilMemberPartial', [ 'council_member' => $attendance_records->first()->getAttendee(), 'attendance' => $attendance_records->first() ])

                <p>
                    With <strong>{{ $attendance_records->first()->votePercent() }}%</strong> attendance for votes in council,
                    {{ $attendance_records->first()->getAttendee() }} has the best attendance.
                </p>
            </div>

            <div class="flex-item">
                @include('councilMemberPartial', [ 'council_member' => $attendance_records->last()->getAttendee(), 'attendance' => $attendance_records->last() ])

                <p>
                    With <strong>{{ $attendance_records->last()->votePercent() }}%</strong> attendance for votes in council,
                    {{ $attendance_records->last()->getAttendee() }} has the worst attendance.
                </p>
            </div>
        </div>

        <style>
            table {
                min-width: 50rem;
                font-size: 18px;
            }
        </style>

        <div class="flex">
            <div class="card">
                <div class="card-content">
                    <table class="striped">
                        <thead>
                        <tr>
                            <th>Councillor</th>
                            <th>Meetings</th>
                            <th>Votes</th>
                            <th>Score</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attendance_records as $attendance_record)
                            <tr>
                                <td>{{ $attendance_record->getAttendee() }}</td>
                                <td>{{ $attendance_record->meetingFraction() }}</td>
                                <td>{{ $attendance_record->voteFraction() }}</td>
                                <td><strong><span data-attendance-percent="{{ $attendance_record->weightedVoteAttendancePercent() }}">{{ $attendance_record->votePercent() }}%</span></strong></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="card">
                <div class="card-content">
                    <p>
                        Of all the meetings, {{ $skipped_meetings->keys()->first() }} is the most likely to have a councillor
                        absent ({{ $skipped_meetings->first()['percentage'] }}% of the time)
                    </p>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Meeting Type</th>
                                <th># of Meetings Skipped</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skipped_meetings as $meeting_type => $skipped)
                                <tr>
                                    <td>{{ $meeting_type }}</td>
                                    <td>{{ $skipped['skipped'] }} ({{ $skipped['percentage'] }}%)</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>


@stop
