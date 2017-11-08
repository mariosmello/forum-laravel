@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title  }}
                    </div>
                    <div class="panel-body">
                        {{$thread->body}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @foreach($thread->replies as $reply)
                        @include('threads.reply')
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            @if(auth()->check())
                <form method="post" action="{{$thread->path() . '/replies'}}">
                    {{ csrf_field() }}
                    <textarea name="body" class="form-control"
                    placeholder="Have something to say?"></textarea>
                    <button type="submit" class="btn btn-default">Post</button>
                </form>
            @else
                <p class="text-center">You need <a href="{{route('login')}}">sign in</a> to participate.</p>
            @endif
            </div>
        </div>

        <br />
        <br />
        <br />
        <br />

    </div>
@endsection
