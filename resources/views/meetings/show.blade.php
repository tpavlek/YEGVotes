@extends('layout')

@section('title')
- {{ $meeting }}
@stop

@section('content')

    <div class="pure-g">
        <div class="pure-u-1 pure-u-lg-1-2">
            <h1>{{ $meeting }}</h1>
            <div style="text-align: left; line-height:1.8em;">

                @include('agendaSectionPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_INQUIRY, 'section_name' => "Councillor Inquiries and Protocol Items" ])

                @include('agendaSectionWithVotesPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_OTHER, 'section_name' => "General" ])

                @include('agendaSectionWithVotesPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_BYLAW, 'section_name' => "Bylaws" ])

                @include('agendaSectionPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_PASSED_WITHOUT_DEBATE, 'section_name' => "Bylaws Passed Without Debate" ])

                @if ($groupedAgendaItems->count() == 0)
                    <h2>There is nothing here!</h2>
                    <p>
                        This usually means that the city clerk has not yet updated the Edmonton Open Data API with
                        this meeting's minutes
                    </p>
                    <a href="{{ URL::to('/') }}" class="button xlarge">Go Home and Try Again</a>
                @endif

            </div>
        </div>
        <div class="pure-u-1 pure-u-lg-1-2">
            @if ($attendance->get(1))
                <h2>Present</h2>
                <div class="pure-g">
                    @foreach ($attendance->get(1) as $attendanceRecord)
                        <div class="pure-u-1 pure-u-md-1-2">
                            <div class="small-person-details">
                                @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee(), 'attendance' => false ])
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
                                @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee(), 'attendance' => false ])
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


@stop
