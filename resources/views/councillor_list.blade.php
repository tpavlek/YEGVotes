@extends('layout')

@section('title')
@stop

@section('content')
<div class="pure-g">
    @foreach ($attendance as $attendanceRecord)
        <div class="pure-u-xl-1-2 pure-u-1">
            <div class="small-person-details">
                @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee(), 'link' => true, 'attendance' => $attendanceRecord ])

            </div>

        </div>
    @endforeach

</div>

@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $("span.vote:not(.motion-list)").click(function() {
                window.location = $(this).data('remote-url');
            });

            $("div.short-title").click(function() {
                window.location = $(this).data('remote-url');
            })


        });
    </script>
@stop
