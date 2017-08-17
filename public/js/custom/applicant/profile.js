$(document).ready(function() {
	//update the picture in the img source
    $("#picture").change(function() {
        readURL(this);
    });

    //validate if the picture is an image
    $('#btnSave').click(function(e) {
        var ext = $('#picture').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            e.preventDefault();

            toastr.error("INVALID IMAGE INPUT");
        }
    });


});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#pictureview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        $('#pictureview').attr('src', '/images/default.png');
    }
}