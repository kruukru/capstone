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

                    var formData = [];
                    $.each(data.test, function(index, value) {
                        var dt = {
                            name: value.name,
                            instruction: value.instruction
                        };
                        formData.push(dt);
                    });

                    window.localStorage.setItem("applicantid", data.applicant.applicantid);
                    window.localStorage.setItem("test", JSON.stringify(formData));
                    window.location.href = "/admin/transaction/testlogin/test";
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