@extends('layout')

@section('title', "$meeting -")

@section('content')

<div class="bg-grey-darkest text-center pt-4 relative">
    <h1 class="text-grey-lightest">
        {{ $meeting }}
    </h1>
    @if ($attendance->count())
        <div class="attendance-wrapper">
            <div class="flex row-wrap justify-center">
                @foreach($attendance as $type => $records)
                    @foreach ($records as $attendanceRecord)
                        <?php /** @var \App\Model\AttendanceRecord $attendanceRecord */ ?>
                        <a href="{{ URL::route('councillor.show', (string)$attendanceRecord->getAttendee()->name) }}" class="p-2 hover:bg-grey-darker" title="{{ $attendanceRecord->getAttendee()->name }}">
                            <div class="block h-16 w-16 rounded-full bg-cover bg-center border-2 @if($type == 1) border-green-dark @else border-red-darker @endif" style="background-image: url({{ $attendanceRecord->getAttendee()->getImageUrl() }})">
                            </div>
                        </a>
                    @endforeach
                @endforeach
            </div>
        </div>
    @endif
    <a href="http://sirepub.edmonton.ca/sirepub/mtgviewer.aspx?meetid={{$meeting->id}}&doctype=MINUTES" class="flex flex-col justify-center absolute pin-r pin-t h-full hover:bg-grey-darker px-4" title="Official Minutes">
        <span class="text-4xl text-grey-lightest">
            <i class="far fa-newspaper"></i>
        </span>
    </a>

</div>


<div class="meeting">
    <div class="agenda-wrapper">

        <div style="text-align: left; line-height:1.8em;">

            @include('agendaSectionPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_INQUIRY, 'section_name' => "Councillor Inquiries" ])

            @include('agendaSectionPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_PRIVATE, 'section_name' => 'Private/FOIP', 'card_class' => 'private' ])

            @include('agendaSectionWithVotesPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_OTHER, 'section_name' => "General" ])

            @include('agendaSectionWithVotesPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_BYLAW, 'section_name' => "Bylaws" ])

            @include('agendaSectionPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_PASSED_WITHOUT_DEBATE, 'section_name' => "Bylaws Passed Without Debate" ])

            @include('agendaSectionPartial', [ 'section_key' => \App\Model\AgendaItem::CATEGORY_REVISED_DUE_DATE, 'section_name' => 'Reports with a Revised Due Date'])

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
                    <div class="card-content">
                        <span class="card-title">Speakers from the Public</span>
                        <ul>
                            @foreach ($speakers as $speaker)
                                <li>
                                    <a href="{{ URL::route('speakers.show', $speaker) }}">{{ $speaker }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>


@stop
