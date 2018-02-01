@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{route('profile', $thread->creator)}}">
                            {{ $thread->creator->name }}
                        </a> posted:
                        {{ $thread->title  }}
                    </div>
                    <div class="panel-body">
                        {{$thread->body}}
                    </div>
                </div>

                @foreach($replies as $reply)
                    <div class="panel panel-default">
                        @include('threads.reply')
                    </div>
                @endforeach

                {{  $replies->links() }}

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

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            This thread was published
                            {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a> and currently has
                            {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <br/>
        <br/>
        <br/>

    </div>
@endsection
