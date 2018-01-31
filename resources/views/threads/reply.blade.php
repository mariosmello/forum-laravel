<div class="panel-heading">
    <div class="level">
        <h5 class="flex">
            <a href="#" title="{{ $reply->owner->name  }}">
                {{ $reply->owner->name  }}
            </a>
            said {{ $reply->created_at->diffForHumans()  }}...
        </h5>

        <div>
            <form action="/replies/{{$reply->id}}/favorites" method="post">
                {{csrf_field()}}
                <button type="submit" class="btn btn-default" {{$reply->isFavorited() ? 'disabled' : ''}}>
                    {{ $reply->favorites()->count() }} {{ str_plural('Favorite', $reply->favorites()->count()) }}
                </button>
            </form>
        </div>
    </div>

</div>

<div class="panel-body">
    {{$reply->body}}
</div>