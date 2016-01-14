@extends('layout')

@section('title')
    - {{ $election->name }} update feed
@stop

@section('content')
    <div class="whitecard">
        <h1>{{ $election->name }} Update Feed</h1>
        <p>
            This is a feed of all relevant updates by all candidates to the ward 12 campaign. This could include
            tweets, videos, facebook posts, blog posts, or anything else! If a news organization or
            a candidate posts some information that would help voters decide whom they would like to support, it should
            go here!
        </p>

        <p>
            This software is crowd-sourced, we rely on you (and the candidates themselves) to submit important information.
            Simply use the button below to submit new content. Be aware that this content is moderated and will be approved
            before it appears on all the feeds here. You can also limit the updates to a single candidate by viewing their
            individual feeds which you can find on the <a href="{{ URL::route('elections.show', $election->id) }}">election page</a>.
        </p>
        <p>
            <a href="{{ URL::route('postable.submit') }}" class="button">
                <i class="fa fa-pencil"></i> Submit New Update
            </a>
        </p>
    </div>

    <div class="flex-justified">
        @foreach($postable_content as $content)
            <div class="whitecard">
                {!! $content->render() !!}

                <div style="text-align: left">
                    <h3>Candidates:</h3>
                    <ul style="text-align: left">


                        @foreach ($content->candidates as $candidate)
                            <li><a href="{{ URL::route('candidate.show', $candidate->slug) }}">{{ $candidate->running_name }}</a></li>
                        @endforeach
                    </ul>
                </div>

            </div>
        @endforeach
    </div>
@stop
