$(document).ready(function() {
    $('#btnSaveCompany').click(function(e) {
        if ($('#formCompany').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#companydetails').loading({
                message: "SAVING..."
            });

            var formData = {
                inputName: $('#name').val(),
                inputShortName: $('#shortname').val(),
                inputAddress: $('#address').val(),
                inputContactNo: $('#contactno').val()
            };

            $.ajax({
                type: "POST",
                url: "/admin/utility/company",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    $('#companydetails').loading('stop');
                    alert("SAVE SUCCESSFUL");
                    window.location.href = "/admin/utility/company";
                }
            });
        }
    });

    $('#btnSaveImage').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var ext = $('#picture').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            toastr.error("INVALID IMAGE INPUT");
            return;
        }

        $('#companylogo').loading({
            message: "SAVING..."
        });
        var image = $('#picture')[0].files[0];
        var form = new FormData();

        form.append('image', image);

        $.ajax({
            type: "POST",
            url: "/admin/utility/company/logo",
            data: form,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {

                $('#formImage').trigger('reset');
                $('#companylogo').loading('stop');
                alert("SAVE SUCCESSFUL");
                window.location.href = "/admin/utility/company";
            },
        });
    });



});