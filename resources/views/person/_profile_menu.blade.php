<div class="list-group push">
    @foreach($menu_list as $name => $url)
        @if(request()->is(substr($url, 1)))
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="background-color: #b3c0cf" href="{{ $url }}">
                <strong class="font-w700">{{ $name }}</strong>
            </a>
        @else
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="color: blue" href="{{ $url }}">
                <strong>{{ $name }}</strong>
            </a>
        @endif
    @endforeach
</div>