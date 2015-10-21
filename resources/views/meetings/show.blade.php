@extends('layout')

@section('content')

    <div class="pure-g">
        <div class="pure-u-1">
            @foreach($meeting->agenda_items as $agenda_item)
                @if ($agenda_item->hasVotes())
                    HAS VOTES
                @endif
                <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}">{{ $agenda_item->title }}</a> <Br />
            @endforeach
        </div>
    </div>
    @if ($attendance->get(1))
        <h2>Present</h2>
        <div class="pure-g">
            @foreach ($attendance->get(1) as $attendanceRecord)
                <div class="pure-u-1-3">
                        <div class="small-person-details">
                            @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee() ])
                        </div>

                </div>
            @endforeach
        </div>
    @endif

    @if ($attendance->get(0))
        <h2>Absent</h2>
        <div class="pure-g">
            @foreach ($attendance->get(0) as $attendanceRecord)
                <div class="pure-u-1-3">
                        <div class="small-person-details">
                            @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee() ])
                        </div>

                </div>
            @endforeach
        </div>
    @endif

@stop
