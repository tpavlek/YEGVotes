@extends('layout')

@section('title')
@stop

@section('content')
    <div class="overview-wrapper">
        <div class="items">
            @forelse ($voting_items as $agenda_index => $agenda_item)
                @include('agendaItemPartial', [ 'agenda_item' => $agenda_item ])
            @empty
                <em>Sorry, we don't have any records on file right now!</em>
            @endforelse
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
