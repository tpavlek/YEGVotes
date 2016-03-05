@extends('layout')

@section('title')
- {{ $meeting }}
@stop

@section('content')

    <div class="pure-g">
        <div class="pure-u-1 pure-u-lg-1-2">
            <h1>{{ $meeting }}</h1>
            <div style="text-align: left; line-height:1.8em;">
                @if ($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_INQUIRY))
                    <div class="whitecard">
                        <h2>Councillor Inquiries and Protocol Items</h2>

                        @foreach($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_INQUIRY) as $agenda_item)

                            <span>{!! $agenda_item->formattedTitle !!}</span>
                            @if ($agenda_item->hasVotes())
                                <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}" class="button xsmall">
                                    <i class="fa fa-arrow-right fa-sm"></i>
                                </a>
                            @endif
                            <br />
                        @endforeach
                    </div>
                @endif

                    @if ($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_OTHER))
                        <div class="whitecard">
                            <h2>General</h2>

                            @foreach($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_OTHER) as $agenda_item)

                                @if ($agenda_item->hasVotes())
                                    @if ($agenda_item->isUnanimous())
                                        <p style="text-align:left;">
                                            <span class="item-title">{!! $agenda_item->formattedTitle !!}</span>
                                            <span style="color:green; font-weight:bold;"><i class="fa fa-check"></i> Unanimous</span>
                                            &nbsp;
                                            <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}">More Info</a>
                                        </p>

                                    @else
                                        @include('agendaItemPartial')
                                    @endif
                                @else
                                    <p style="text-align:left;">
                                        <span class="item-title">{!! $agenda_item->formattedTitle !!}</span>
                                        <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}">More Info</a>
                                    </p>
                                @endif
                            @endforeach

                        </div>
                    @endif

                @if ($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_BYLAW))
                    <div class="whitecard">
                        <h2>Bylaws</h2>

                        @foreach($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_BYLAW) as $agenda_item)

                            @if ($agenda_item->hasVotes())
                                @if ($agenda_item->isUnanimous())
                                    <p style="text-align:left;">
                                        <span class="item-title">{!! $agenda_item->formattedTitle !!}</span>
                                        <span style="color:green; font-weight:bold;"><i class="fa fa-check"></i> Unanimous</span>
                                        &nbsp;
                                        <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}">More Info</a>
                                    </p>

                                @else
                                    @include('agendaItemPartial')
                                @endif
                            @else
                                <p style="text-align:left;">
                                    <span class="item-title">{!! $agenda_item->formattedTitle !!}</span>
                                    <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}">More Info</a>
                                </p>
                            @endif

                        @endforeach

                    </div>
                @endif




                @if ($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_PASSED_WITHOUT_DEBATE) or null)
                    <div class="whitecard">
                        <h2>Bylaws Passed Without Debate</h2>

                        @foreach($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_PASSED_WITHOUT_DEBATE) as $agenda_item)

                            <span>{!! $agenda_item->formattedTitle !!}</span>
                            @if ($agenda_item->hasVotes())
                                <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}" class="button xsmall">
                                    <i class="fa fa-arrow-right fa-sm"></i>
                                </a>
                            @endif
                            <br />
                        @endforeach

                    </div>
                @endif

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
