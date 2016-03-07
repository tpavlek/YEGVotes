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


            @include('agendaSectionPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_INQUIRY, 'section_name' => "Councillor Inquiries and Protocol Items", 'card_class' => "half" ])

            @include('agendaSectionPartial', [ 'section_key' => \Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_PASSED_WITHOUT_DEBATE, 'section_name' => "Bylaws Passed Without Debate", 'card_class' => "half" ])

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
    <script>
        $(document).ready(function() {
            $("input[type='checkbox']").click(function() {
                var thisId = $(this).attr('id');
                var otherChecks = $(this).parents('.motions').find('input:checked:not(#' + thisId + ')');
                otherChecks.each(function (index) {
                    $(otherChecks[index]).removeAttr('checked');
                });

            });
        });
    </script>
@stop
