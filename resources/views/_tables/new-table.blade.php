{{--
REQUIRED
$table_head = array of header names

--}}

<table class="table table-hover table-vcenter {{ $class ?? '' }}" id="{{ $id }}" style="{{ $style ?? '' }}">
    <thead>
    <tr>
        @foreach($table_head as $name)
            <th>{{ $name }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
