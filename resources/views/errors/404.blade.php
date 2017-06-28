@extends('layout')

@section('title', "Not Found")

@section('content')
    <div class="flex-justified" style="text-align: center;">
        <div class="column">
            <div class="whitecard">
                <h3>404 - Not Found</h3>
                <p>
                    Sorry, we could not find what you were looking for!
                </p>

                <p>
                    If you think this is in error and it <em>should</em> be here, use the contact below to let me know
                </p>
                <p>
                    <a href="https://twitter.com/troypavlek" class="button"><i class="fa fa-twitter"></i> Tweet @troypavlek</a>
                    <a href="mailto:troy@tpavlek.me?subject=Not Found on YEGVotes" class="button"><i class="fa fa-envelope"></i> Email troy@tpavlek.me</a>
                </p>
            </div>
        </div>

    </div>

@stop
