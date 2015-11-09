@extends('layout')

@section('title')
@stop

@section('content')
<div class="pure-g">
    <div class="pure-u-1 pure-u-lg-1-2 pure-u-xl-3-5">
        @forelse ($voting_items as $agenda_index => $agenda_item)
            <div class="item-container">
                <header class="agenda-item-topic">{{ $agenda_item }}</header>
                <div class="motions">
                    @foreach ($agenda_item->motions as $index => $motion)
                        <div class="motion {{ $motion->getIndicatorString() }}">
                            <div class="motion-indicator">
                                <input type="checkbox" name="tabs" id="motion{{$motion->id}}" />
                                <label for="motion{{$motion->id}}">
                                    @if ($motion->getIndicatorString() == "Failed")
                                        <i class="fa fa-times-circle"></i>
                                    @elseif($motion->getIndicatorString() == "Unanimous")
                                        <i class="fa fa-check-circle"></i>
                                    @elseif($motion->getIndicatorString() == "Disagreement")
                                        <i class="fa fa-exclamation-circle"></i>
                                    @else
                                        <i class="fa fa-info-circle"></i>
                                    @endif
                                </label>
                                <div id="motion-content{{$motion->id}}" class="motion-content">
                                    <a href="{{ URL::route('motion.show', $motion->id) }}" class="button small secondary">
                                        Show Motion
                                    </a>
                                    <p>
                                        {!! $motion !!}
                                    </p>
                                    @include('voteTablePartial', [ 'votes' => $motion->votes->groupBy('vote') ])
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                <br style="clear: both;" />
                <a href="{{ URL::route('agenda_item.show', $agenda_item->id) }}" class="button small">
                    <i class="fa fa-eye"></i> View Agenda
                </a>
            </div>
        @empty
            <em>Sorry, we don't have any records on file right now!</em>
        @endforelse
    </div>
    <div class="pure-u-1 pure-u-lg-1-2 pure-u-xl-2-5">
        @foreach ($attendance as $attendanceRecord)
            <div class="pure-u-xl-1-2 pure-u-1">
                <div class="small-person-details">
                    @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee(), 'link' => true, 'attendance' => $attendanceRecord ])

                </div>

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