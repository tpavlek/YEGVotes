@extends('layout')

@section('title')
    - Administration
@stop

@section('content')
    <h2>Postable Content</h2>
    <div class="flex-justified">
        @forelse($postable_content as $content)
            <div class="whitecard">
                {!! $content->render() !!}

                <div>
                <form action="{{ URL::route('postable.approve', $content->id) }}" method="POST" class="inline-form">
                    {{ csrf_field() }}

                    <input type="hidden" name="type" value="{{ get_class($content) }}" />

                    <button type="submit" class="button success">
                        <i class="fa fa-check"></i> Approve
                    </button>

                </form>

                    <form action="{{ URL::route('postable.deny', $content->id) }}" method="POST" class="inline-form">
                        {{ csrf_field() }}

                        <input type="hidden" name="type" value="{{ get_class($content) }}" />

                        <button type="submit" class="button bad">
                            <i class="fa fa-times"></i> Deny
                        </button>

                    </form>

                </div>
            </div>
        @empty
            <div class="whitecard">
                <em>Nothing here, boss!</em>
            </div>
        @endforelse
    </div>
@stop

@section('additional_nav')
    <li>
        <a href="{{ URL::route('admin.logout') }}">Log Out</a>
    </li>
@stop
