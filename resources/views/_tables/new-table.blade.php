{{--
REQUIRED
$table_head = array of header names

--}}

<table class="table
@if (! isset($no_hover))
table-hover
@endif
table-sm table-vcenter {{ $class ?? '' }}" id="{{ $id }}" style="{{ $style ?? '' }}">
    <thead>
    <tr>
        @foreach($table_head as $name)
            <th>{{ $name }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
