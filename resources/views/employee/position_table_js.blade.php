const tableposition = $('#position_table').DataTable({
dom: "frtip",
select: true,
paging: true,
pageLength: 10,
ajax: {"url": "/api/position/ajaxshowposition", "dataSrc": ""},
columns: [
{data: "name"},
{data: "type.name"},
{data: "school.name"},
{
data: "stipend",
render: function (data, type, row) {
@if (auth()->user()->can('positions.show.stipend'))
if (data == null || data == '') {
return 0 + ' ¥';
}
return data + ' ¥';
@else
    return '---';
    @endif
}
},
{data: "uuid",
render: function(data, type, row) {
@can('employees.update.employment')
return "<button type=\"button\" class=\"btn btn-sm btn-outline-success\" dusk=\"" + data + "\" data-toggle=\"tooltip\" title=\"Add Position\"\n" +
"                onclick=\"window.location.href='/employee/{{ $employee->uuid }}/position/" + data + "/add'\">\n" +
"            <i class=\"fa fa-plus-circle\"></i> Add\n" +
"        </button>";
@endcan
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
