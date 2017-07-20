$(document).ready(function () {
    $('#tasks').DataTable({
        "paging": false,
        "searching": false,
        "aaData": orgContent,
        "columns": [
            null,
            null,
            {"orderable": false},
            {"orderable": false},
            null
        ]
    });
});