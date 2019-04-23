var tableposition = $('#position_table').DataTable({
dom: "Bfrtip",
select: true,
paging: true,
pageLength: 10,
ajax: {"url": "/api/position/ajaxshowposition", "dataSrc": ""},
columns: [
{data: "name"},
{data: "type.name"},
{data: "school.name"},
{data: "stipend"},
{data: "uuid",
render: function(data, type, row) {
return "<button type=\"button\" class=\"btn btn-sm btn-outline-success\" data-toggle=\"tooltip\" title=\"Add Position\"\n" +
"                onclick=\"window.location.href='/employee/{{ $employee->uuid }}/position/" + data + "/add'\">\n" +
"            <i class=\"fa fa-plus-circle\"></i> Add\n" +
"        </button>";
}
}
]
});
new $.fn.dataTable.Buttons(tableposition, {
buttons: [
'copy',
'excel',
'csv',
{
extend: 'pdf',
orientation: 'landscape',
pageSize: 'LETTER'
},
'print'
]
});

tableposition.buttons(2, null).container().appendTo(
tableposition.table().container()
);
