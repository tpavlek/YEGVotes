@extends('layout')

@section('title')
    - Track Edmonton City Councillors
@stop

@section('content')
    <h1>
        {{ $last_meeting->title }}
        <a href="{{ URL::route('meetings.show', $last_meeting->id) }}" class="button small">
            <i class="fa fa-arrow-right"></i>
        </a>
    </h1>

    <div class="overview-wrapper">

        <div class="items">

            @include('agendaSectionWithVotesPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_INQUIRY, 'section_name' => "Councillor Inquiries", 'card_class' => "full" ])

            @include('agendaSectionPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_PRIVATE, 'section_name' => 'Private/FOIP', 'card_class' => 'private full' ])

            @include('agendaSectionPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_PASSED_WITHOUT_DEBATE, 'section_name' => "Bylaws Passed Without Debate", 'card_class' => "full" ])

            @include('agendaSectionWithVotesPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_OTHER, 'section_name' => "General", 'card_class' => "full" ])

            @include('agendaSectionWithVotesPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_BYLAW, 'section_name' => "Bylaws", 'card_class' => "full"])
        </div>

        <div class="attendance-record">
            @foreach ($attendance as $attendanceRecord)
                <div class="small-person-details">
                    @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee(), 'link' => true, 'attendance' => $attendanceRecord ])
                </div>
            @endforeach
        </div>

    </div>

@stop

@section('scripts')

@stop
