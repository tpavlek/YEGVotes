<?php /** @var \App\Model\AttendanceRecord $attendanceRecord */ ?>
@extends('layout')

@section('title', "{$attendanceRecord->getAttendee()} -")

@section('meta_description')
    About {{ $attendanceRecord->getAttendee() }}. {{ $attendanceRecord->getAttendee() }}'s attendance for City Council votes
    is {{ $attendanceRecord->votePercent() }}%. View the most recent voting record for this councillor.
@stop

@section('content')
    <div>
        <div class="text-center">
            <div class="flex justify-center">
                @include('councilMemberPartial', [ 'attendance_record' => $attendanceRecord ])
            </div>
        </div>
    </div>

@stop

@section('scripts')
@stop
