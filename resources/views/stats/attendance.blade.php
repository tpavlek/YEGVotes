@extends('layout')

@section('title', "How often do Edmonton City Councillors skip meetings? -")

@section('meta_description', "At a " . $skipped_meetings->keys()->first() . " there is a " . $skipped_meetings->first()['percentage'] . "% chance of a councillor being absent")

@section('meta_image', '/img/attendance.png')

@section('content')
    <div class="text-center mt-4 text-grey-darker">
        <h1>How often do Edmonton City Councillors attend meetings?</h1>

        <div class="p-8 flex flex-row">
            <div class="flex-grow">
                @include('councilMemberPartial', [ 'attendance_record' => $attendance_records->first() ])

                <p class="mt-4 text-left">
                    With <strong>{{ $attendance_records->first()->votePercent() }}%</strong> attendance for votes in council,
                    {{ $attendance_records->first()->getAttendee() }} has the best attendance.
                </p>
            </div>

            <div class="flex-grow">
                @include('councilMemberPartial', [ 'attendance_record' => $attendance_records->last() ])

                <p class="mt-4 text-left">
                    With <strong>{{ $attendance_records->last()->votePercent() }}%</strong> attendance for votes in council,
                    {{ $attendance_records->last()->getAttendee() }} has the worst attendance.
                </p>
            </div>
        </div>

        <div class="flex">
            <div class="card mx-auto m-2 leading-loose">
                <table class="">
                    <thead>
                        <tr>
                            <th class="p-2 text-grey-dark font-bold text-lg">Councillor</th>
                            <th class="p-2 text-grey-dark font-bold text-lg">Meetings</th>
                            <th class="p-2 text-grey-dark font-bold text-lg">Votes</th>
                            <th class="p-2 text-grey-dark font-bold text-lg">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($attendance_records as $attendance_record)
                        <tr>
                            <td class="p-2 pr-8 text-grey-dark">{{ $attendance_record->getAttendee() }}</td>
                            <td class="p-2 pr-8 text-grey-dark">{{ $attendance_record->meetingFraction() }}</td>
                            <td class="p-2 pr-8 text-grey-dark">{{ $attendance_record->voteFraction() }}</td>
                            <td class="p-2 {{ (new \App\Template\AttendanceTemplate($attendance_record))->ratingColor() }}"><strong><span data-attendance-percent="{{ $attendance_record->weightedVoteAttendancePercent() }}">{{ $attendance_record->votePercent() }}%</span></strong></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="card mx-auto leading-loose mb-8">
                <div class="p-8 text-left">
                    <p class="text-grey-darker">
                        Of all the meetings, {{ $skipped_meetings->keys()->first() }} is the most likely to have a councillor
                        absent ({{ $skipped_meetings->first()['percentage'] }}% of the time)
                    </p>
                    <table class="p-8 pb-0 text-grey-darker">
                        <thead>
                            <tr>
                                <th>Meeting Type</th>
                                <th># of Meetings Skipped</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skipped_meetings as $meeting_type => $skipped)
                                <tr>
                                    <td class="pr-8">{{ $meeting_type }}</td>
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
