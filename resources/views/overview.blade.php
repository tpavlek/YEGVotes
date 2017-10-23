@extends('layout')

@section('title', "Track Edmonton City Councillors -")

@section('content')
    <h1>
        {{ $last_meeting->title }}
        <a href="{{ URL::route('meetings.show', $last_meeting->id) }}" class="button small">
            <i class="fa fa-arrow-right"></i>
        </a>
    </h1>

    <div class="overview-wrapper">

        <div class="items">

            @include('agendaSectionWithVotesPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_INQUIRY, 'section_name' => "Councillor Inquiries", 'card_class' => "full" ])

            @include('agendaSectionPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_PRIVATE, 'section_name' => 'Private/FOIP', 'card_class' => 'private full' ])

            @include('agendaSectionPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_PASSED_WITHOUT_DEBATE, 'section_name' => "Bylaws Passed Without Debate", 'card_class' => "full" ])

            @include('agendaSectionWithVotesPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_OTHER, 'section_name' => "General", 'card_class' => "full" ])

            @include('agendaSectionWithVotesPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_BYLAW, 'section_name' => "Bylaws", 'card_class' => "full"])
        </div>

        <div class="attendance-record-wrapper">
            @foreach ($attendance as $attendanceRecord)
                @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee(), 'attendance' => $attendanceRecord ])
            @endforeach
        </div>

    </div>

@stop

@section('scripts')

@stop
