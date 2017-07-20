function readUrl(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#uploadedPicture img').attr('src', e.target.result);
            $('#uploadedPicture img').attr('width', 320);
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
        $('#previewPicture').attr('src', $('#uploadedPicture img').attr('src'));
        $('#previewPicture').attr('width', $('#uploadedPicture img').attr('width'));
    });

    $("#idPicture").change(function () {
        readUrl(this);
    });
});