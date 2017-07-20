$(document).ready(function () {
    $('#tasks').DataTable({
        "paging": false,
        "searching": false,
        "columns": [
            null,
            null,
            {"orderable": false},
            {"orderable": false},
            null
        ]
    });
});