@extends('layout')

@section('title')
    - Feature Overview
@stop

@section('content')
    <h2 class="section-header">
        About YEGVotes.info
    </h2>

    <div class="section">
        <p>
            <a href="{{ URL::route('home.index') }}">YEGVotes.info</a> is a website made by <a href="http://tpavlek.me">Troy Pavlek</a>,
            a resident of <a href="http://hazeldean.org">Hazeldean</a> and a fan of municipal politics.
        </p>

        <p>
            Some of the things you can track on the site are:

        </p>

        <div class="site-demo-examples">
            @include('about.attendance')

            <div class="example">
                <div class="whitecard">
                    <h3>Summaries for agenda items with votes</h3>
                    @include('agendaItemPartial', [ 'agenda_item' => $agenda_item ])
                    <p>
                        Interested in what happened last meeting? Catching up on the past few months? YEGVotes includes
                        a breakdown of each item on the agenda for all Council meetings, and easily shows which motions were
                        unanimous, which motions failed, and which one had a dissenting voice.
                    </p>

                    <p>
                        Just click on any one of the motions to explore the motion text and what each councillor voted!
                    </p>
                </div>
            </div>

            <div class="example">
                <div class="whitecard">
                    <h3>Councillor Voting Records</h3>
                    <p>
                        Drill down and look at every bylaw each councillor voted on - you can also show only the votes
                        they opposed!
                    </p>
                    @include('councilMemberPartial', [ 'council_member' => $councillor, 'link' => false ])
                    @include('councillor.votingSummaryPartial', [ 'councillor' => $councillor ])
                </div>
            </div>
        </div>
    </div>


@stop


@section('scripts')
    <script>
        $(document).ready(function() {
            $("div.vote").click(function() {
                window.location = $(this).data('remote-url');
            });

        });
    </script>
@stop
