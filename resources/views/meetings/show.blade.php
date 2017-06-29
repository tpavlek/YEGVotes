@extends('layout')

@section('title', "$meeting -")

@section('content')

<h1>{{ $meeting }} <a href="http://sirepub.edmonton.ca/sirepub/mtgviewer.aspx?meetid={{$meeting->id}}&doctype=MINUTES" class="btn">Official Minutes <i class="fa fa-arrow-right"></i></a></h1>

<div class="meeting">
    <div class="agenda-wrapper">

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

    @if ($attendance->count())
        <div class="attendance-wrapper">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Attendance</span>
                </div>
                @foreach($attendance as $type => $records)
                    <div class="card-content @if ($type) green @else red darken-2 @endif">

                        @if ($type)
                            <span class="card-title white-text"><small><i class="fa fa-check-circle"></i> &nbsp; Present</small></span>
                        @else
                            <span class="card-title white-text"><small><i class="fa fa-times-circle"></i> &nbsp; Absent</small></span>
                        @endif
                        @foreach ($records as $attendanceRecord)
                            <div style="padding: 0.5rem;">
                                <a href="{{ URL::route('councillor.show', (string)$attendanceRecord->getAttendee()) }}">{{ $attendanceRecord->getAttendee() }}</a>
                            </div>

                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>


@stop
