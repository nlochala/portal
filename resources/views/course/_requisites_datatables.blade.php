    var editor{{ $type }} = new $.fn.dataTable.Editor({
        ajax: "{{ url('api/course/'.$course->uuid.'/ajaxstore'.$type) }}",
        table: "#{{ $type }}_table",
        idSrc: 'id',
        fields: [
    {
        label: "Course",
        name: "course_id",
        type: "select2",
        opts: {
            placeholder: "Choose One..."
        },
        options: [
            @foreach($add_course_dropdown as $add_course)
            {
                label: "{{ $add_course->full_name }}", value: "{{ $add_course->id }}"
            },
            @endforeach
        ]
    }

    ]
    });

    var table{{ $type }} = $('#{{ $type }}_table').DataTable({
        dom: "Bfrtip",
        select: true,
        paging: true,
        pageLength: 50,
        ajax: {"url": "{{ url('api/course/'.$course->uuid.'/ajaxshow'.$type) }}", "dataSrc": ""},
        columns: [
            {data: "id"},
            {data: "short_name"},
            {data: "name"},
            {data: "type.name"},
            {data: "department.name"},
        ],
        buttons: [
            {
                extend: 'collection',
                text: '<i class="fa fa-fw fa-download mr-1"></i>',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LETTER'
                    },
                    'print',
                ],
                fade: true,
                className: 'btn-sm btn-hero-primary'
            },
            {
                text: '',
                className: 'btn-sm btn-light',
                action: function (e, dt, node, config) {
                    this.disable();
                }
            },
            {extend: "create", editor: editor{{ $type }}, className: 'btn-sm btn-hero-primary'},
            {extend: "remove", editor: editor{{ $type }}, className: 'btn-sm btn-hero-danger'},

        ]
    });
