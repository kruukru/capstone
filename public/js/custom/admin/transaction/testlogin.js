$(document).ready(function() {
    $('#btnLogin').click(function(e) {
        if($('#formTestLogin').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/admin/transaction/testlogin",
                data: { inputUsername: $('#username').val(), inputPassword: $('#password').val(), },
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    window.localStorage.setItem("applicantid", data.applicantid);
                    window.location.href = "/admin/transaction/test";
                },
                error: function(data) {
                    console.log(data);

                    if(data.responseJSON == "INVALID USERNAME/PASSWORD") {
                        toastr.error("INVALID USERNAME/PASSWORD");
                    } else if (data.responseJSON == "INVALID DATE") {
                        toastr.error("INVALID APPOINTMENT DATE");
                    }
                },
            });
        }
    });


});