@extends('layout')

@section('title')
- {{ $meeting }}
@stop

@section('content')

    <div class="pure-g">
        <div class="pure-u-1 pure-u-lg-1-2">
            <h1>{{ $meeting }}</h1>
            <div style="text-align: left; line-height:1.8em;">
                @forelse($meeting->agenda_items as $agenda_item)
                    <span>{{ $agenda_item->title }}</span>
                    @if ($agenda_item->hasVotes())
                        <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}" class="button xsmall">
                            <i class="fa fa-arrow-right fa-sm"></i>
                        </a>
                    @endif
                    <br />
                @empty
                    <h2>There is nothing here!</h2>
                    <p>
                        This usually means that the city clerk has not yet updated the Edmonton Open Data API with
                        this meeting's minutes
                    </p>
                    <a href="{{ URL::to('/') }}" class="button xlarge">Go Home and Try Again</a>
                @endforelse
            </div>
        </div>
        <div class="pure-u-1 pure-u-lg-1-2">
            @if ($attendance->get(1))
                <h2>Present</h2>
                <div class="pure-g">
                    @foreach ($attendance->get(1) as $attendanceRecord)
                        <div class="pure-u-1 pure-u-md-1-2">
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
                        <div class="pure-u-1 pure-u-md-1-2">
                            <div class="small-person-details">
                                @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee() ])
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


@stop
