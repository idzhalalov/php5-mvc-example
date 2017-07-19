function readUrl(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#previewUploadPicture').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function () {
    $('#previewBtn').click(function () {
        $('#previewName').text($('#idUserName').val());
        $('#previewEmail').text($('#idUserEmail').val());
        $('#previewText').text($('#idText').val());
        var statusText = $('#idStatus').is(':checked') != true ? 'Active' : 'Done';
        $('#previewStatus').text(statusText);
        // preview image
        readUrl($("#idPicture"));
        $('#previewPicture').attr('src', $('#previewUploadPicture').attr('src'));
    });

    $("#idPicture").change(function () {
        readUrl(this);
    });
});