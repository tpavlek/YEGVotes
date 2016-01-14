<div class="whitecard candidate">
    <a class="candidate-link-area" href="{{ URL::route('candidate.show', $candidate->id) }}">
        <div class="candidate-image-container">
            <img class="candidate-image" src="{{ $candidate->img_url }}" />
        </div>
        <h3>{{ $candidate->running_name }}</h3>
    </a>

    @if($candidate->facebook)
        <a class="media-link" href="https://facebook.com/{{$candidate->facebook}}" title="Facebook"><i class="fa fa-2x fa-facebook-official"></i></a>
    @endif
    @if($candidate->twitter)
        <a class="media-link" href="https://twitter.com/{{$candidate->twitter}}" title="Twitter"><i class="fa fa-2x fa-twitter"></i></a>
    @endif
    @if ($candidate->website)
        <a class="media-link" href="{{ $candidate->website }}" title="Website"><i class="fa fa-2x fa-link"></i></a>
    @endif

    <p>
        <strong>Email</strong>:
        @if ($candidate->email)
            <a href="mailto:{{$candidate->email}}">{{$candidate->email}}</a>
        @else
            <em>Not Provided</em>
        @endif
        <br />
        <br />
        <strong>Phone:</strong>
        @if ($candidate->phone)
            {{ $candidate->phone }}
        @else
            <em>Not Provided</em>
        @endif

    </p>

</div>
