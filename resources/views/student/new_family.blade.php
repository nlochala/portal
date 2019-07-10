@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('student._horizontal_menu')
    @include('layouts._content_start')
    {{--    <h1 class="font-w400" style="text-align: center">{{ $student->person->fullName()}}'s Family</h1>--}}
    <!--
    panel.row
    panel.column
    panel.panel
    panel.panel

    ---------------
    panel.row
    panel.column
    panel.panel
    panel.column
    panel.panel

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->

    <div style="text-align: center">
        <h2 class="font-w400" style="text-align: center">{{ $student->person->fullName()}} does not have a family.</h2>
        <button style="width: 25%" class="btn btn-hero-lg btn-hero-primary"
                onclick="location.href='/student/{{ $student->uuid }}/create_new_family'"
                data-toggle="click-ripple">Create new family</button>
        <br/>
        <br/>
        <button style="width: 25%" class="btn btn-hero-lg btn-hero-primary"
                data-toggle="modal" data-target="#modal-block-families">Add to existing family
        </button>
        <hr/>
    </div>


    @include('layouts._content_end')

    <!-------------------------------- Modal: Existing Families Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-families',
        'title' => 'Existing Families'
    ])

    @include('_tables.new-table',['style' => 'width: 100%', 'id' => 'families-table', 'table_head' => ['ID','Students','Guardians', 'Options']])
    @include('_tables.end-new-table')

    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Existing Families END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-families". ----->
@endsection


@section('js_after')

    {!! JsValidator::formRequest('\App\Http\Requests\StoreStudentProfileRequest','#admin-form') !!}
    {!! JsValidator::formRequest('\App\Http\Requests\StoreStudentImageRequest','#profile-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            const tableposition = $('#families-table').DataTable({
                dom: "frtip",
                select: true,
                paging: true,
                pageLength: 10,
                ajax: {"url": "/api/family/ajaxshowfamilies", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {
                        data: "students",
                        render: function (data, type, row) {
                            let return_name = '';
                            for(let i = 0; i < data.length; i++) {
                                let name = data[i].person.family_name + ', ' + data[i].person.given_name;
                                if (data[i].person.name_in_chinese !== null) {
                                    name += ' ' + data[i].person.name_in_chinese;
                                }
                                if (data[i].person.preferred_name !== null && data[i].person.preferred_name !== data[i].person.given_name) {
                                    name += ' (' + data[i].person.preferred_name + ')';
                                }
                                if(i === 0){
                                    return_name += name;
                                }else{
                                    return_name += '<br />'+name;
                                }
                            }

                            return return_name;
                        }
                    },
                    {
                        data: "guardians",
                        render: function (data, type, row) {
                            let return_name = '';
                            for(let i = 0; i < data.length; i++) {
                                let name = data[i].person.title + ' ' + data[i].person.family_name + ', ' + data[i].person.given_name;
                                if (data[i].person.name_in_chinese !== null) {
                                    name += ' ' + data[i].person.name_in_chinese;
                                }
                                if (data[i].person.preferred_name !== null && data[i].person.preferred_name !== data[i].person.given_name) {
                                    name += ' (' + data[i].person.preferred_name + ')';
                                }
                                if(i === 0){
                                    return_name += name;
                                }else{
                                    return_name += '<br />'+name;
                                }
                            }

                            return return_name;
                        }
                    },
                    {
                        data: "uuid",
                        render: function (data, type, row) {
                            return "<button type=\"button\" class=\"btn btn-sm btn-outline-success\" dusk=\"" + data + "\" data-toggle=\"tooltip\" title=\"Add To Family\"\n" +
                                "                onclick=\"window.location.href='/student/{{ $student->uuid }}/add_to_existing_family/" + data + "'\">\n" +
                                "            <i class=\"fa fa-plus-circle\"></i> Add\n" +
                                "        </button>";
                        }
                    }
                ]
            });
            new $.fn.dataTable.Buttons(tableposition, {
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
                    }
                ]
            }).container().prependTo(tableposition.table().container());
        });
    </script>
@endsection