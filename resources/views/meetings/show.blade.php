@extends('layout')

@section('title', "$meeting -")

@section('content')

<div class="meeting">
    <div class="agenda-wrapper">
        <h1>{{ $meeting }} <a href="http://sirepub.edmonton.ca/sirepub/mtgviewer.aspx?meetid={{$meeting->id}}&doctype=MINUTES" class="button small">Official Minutes <i class="fa fa-arrow-right"></i></a></h1>
        <div style="text-align: left; line-height:1.8em;">

            @include('agendaSectionPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_INQUIRY, 'section_name' => "Councillor Inquiries" ])

            @include('agendaSectionPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_PRIVATE, 'section_name' => 'Private/FOIP', 'card_class' => 'private' ])

            @include('agendaSectionWithVotesPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_OTHER, 'section_name' => "General" ])

            @include('agendaSectionWithVotesPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_BYLAW, 'section_name' => "Bylaws" ])

            @include('agendaSectionPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_PASSED_WITHOUT_DEBATE, 'section_name' => "Bylaws Passed Without Debate" ])

            @include('agendaSectionPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_REVISED_DUE_DATE, 'section_name' => 'Reports with a Revised Due Date'])

            @if ($groupedAgendaItems->count() == 0)
                <h2>There is nothing here!</h2>
                <p>
                    This usually means that the city clerk has not yet updated the Edmonton Open Data API with
                    this meeting's minutes
                </p>
                <a href="{{ URL::to('/') }}" class="button xlarge">Go Home and Try Again</a>
            @endif

            @if(count($speakers))

                <div class="card">
                    <h2>Speakers from the Public</h2>
                    <ul>
                        @foreach ($speakers as $speaker)
                            <li>
                                <a href="{{ URL::route('speakers.show', $speaker) }}">{{ $speaker }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>

    <div class="attendance-wrapper">
        @if ($attendance->get(1))
            <h2>Present</h2>
            @foreach ($attendance->get(1) as $attendanceRecord)
                <div class="small-person-details">
                    @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee(), 'attendance' => false ])
                </div>

            @endforeach
        @endif

        @if ($attendance->get(0))
            <h2>Absent</h2>
            @foreach ($attendance->get(0) as $attendanceRecord)
                <div class="small-person-details">
                    @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee(), 'attendance' => false ])
                </div>
            @endforeach
        @endif
    </div>
</div>


@stop
