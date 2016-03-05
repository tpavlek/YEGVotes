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
            @if ($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_INQUIRY))
                <div class="whitecard half">
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

                @if ($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_PASSED_WITHOUT_DEBATE) or null)
                    <div class="whitecard half">
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

            @if ($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_BYLAW))
                <div class="whitecard full">
                    <h2>Bylaws</h2>
                    @foreach($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_BYLAW) as $agenda_item)

                        @if ($agenda_item->hasVotes() && $agenda_item->isUnanimous())
                            <p style="text-align:left;">
                                <span class="item-title">{!! $agenda_item->formattedTitle !!}</span>
                                <span style="color:green; font-weight:bold;"><i class="fa fa-check"></i> Unanimous</span>
                                &nbsp;
                                <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}">More Info</a>
                            </p>
                        @else
                            @include('agendaItemPartial')
                        @endif
                    @endforeach
                </div>

            @endif


            @if ($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_OTHER))
                <div class="whitecard full">
                    <h2>Other</h2>

                    @foreach($groupedAgendaItems->get(\Depotwarehouse\YEGVotes\Model\AgendaItem::CATEGORY_OTHER) as $agenda_item)

                        @if ($agenda_item->hasVotes() && $agenda_item->isUnanimous())
                            <p style="text-align:left;">
                                <span class="item-title">{!! $agenda_item->formattedTitle !!}</span>
                                <span style="color:green; font-weight:bold;"><i class="fa fa-check"></i> Unanimous</span>
                                &nbsp;
                                <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}">More Info</a>
                            </p>
                        @else
                            @include('agendaItemPartial')
                        @endif
                    @endforeach

                </div>
            @endif


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
