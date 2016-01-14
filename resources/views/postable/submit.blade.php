@extends('layout')

@section('title')
    - Submit new campaign update
@stop

@section('content')
    <h1>Submit a new campaign update</h1>

    <div class="flex">
        <div class="whitecard" style="max-width: 45%">
            <p>
                Please choose the candidates who are affected by this update. If it a single tweet from a candidate, just selecting
                them will be fine. But if it's a news video or article, please try to select all candidates who are mentioned
                in it.
            </p>
        </div>

        <div class="whitecard" style="max-width:45%; text-align:left;">
            <h3>Supported Post Types</h3>

            <ul>
                <li>
                    <strong>Tweets</strong>: Please submit the entire tweet URL <strong>including https://</strong>. For example:
                            <a href="https://twitter.com/troypavlek/status/687392869032706048">https://twitter.com/troypavlek/status/687392869032706048</a>
                </li>
                <li>
                    <strong>Facebook Posts</strong>: Facebook posts must be public to be submitted. Please submit the full URL to the post, including https://
                </li>
                <li>
                    <strong>Youtube Video</strong>: Simply submit the full YouTube URL.
                </li>
                <li>
                    <strong>Other</strong>: Post the link, text, whatever and I'll deal with it on approval
                </li>
            </ul>

            If you want to submit a piece of content that's not officially supported yet, drop an email to <a href="mailto:troy@tpavlek.me">troy@tpavlek.me</a>
            and let me know! I'd be happy to add it for you.
        </div>
    </div>





    <form action="{{ URL::route('postable.store') }}" method="POST" class="pure-form pure-form-aligned">
        {{ csrf_field() }}

        <div class="pure-control-group">
            <label for="postable_type">Update Type</label>
            <select name="postable_type" title="Update Type">
                <option value="tweet">Tweet</option>
                <option value="facebook">Facebook Post</option>
                <option value="youtube">Youtube Video</option>
                <option value="other">Other</option>
            </select>
        </div>

        <label for="content">Content</label>
        <textarea required rows=4 cols=80 name="content" title="content" placeholder="Please enter the update content here. Use the guide above to determine what to enter"></textarea>

        <p>
            You can hold down <strong>ctrl</strong> while clicking to select multiple candidates
        </p>

        <div class="pure-control-group">
            <label for="candidates[]">Relevant Candidates</label>
            <select name="candidates[]" title="Relevant Candidates" multiple style="width:400px; height:400px;" required>
                @foreach($candidates as $candidate)
                    <option value="{{ $candidate->id }}" @if(Input::get('candidate') == $candidate->id) selected @endif>{{ $candidate->running_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="button success">
            <i class="fa fa-check"></i> Submit Update
        </button>

    </form>
@stop
