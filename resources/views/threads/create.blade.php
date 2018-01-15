@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a New Thread</div>
                    <div class="panel-body">
                        <form method="post" action="/threads">

                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="channel_id">Choose a Channel:</label>
                                <select id="channel_id" name="channel_id" class="form-control" required>
                                    <option value="">Choose one...</option>
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}"
                                                {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{$channel->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" required
                                       name="title" value="{{old('title')}}">
                            </div>
                            <div class="form-group">
                                <label for="title">Body:</label>
                                <textarea class="form-control" rows="8" required
                                          name="body">{{old('title')}}</textarea>
                            </div>

                            <button type="submit" class="btn btn-default">Publish</button>
                        </form>

                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
