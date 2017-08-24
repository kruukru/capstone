$(document).ready(function() {
    var applicantid = window.localStorage.getItem("applicantid");
    localStorage.removeItem("applicantid");

    var formData = [];
    var testtime = 0;
    var timer = null;

    $(window).scroll(function () {
        if ($(window).scrollTop() > 51) {
            $('#timeLimit').addClass('fix-top col-md-offset-8');
        }
        if ($(window).scrollTop() < 52) {
            $('#timeLimit').removeClass('fix-top col-md-offset-8');
        }
    });

    //start the timer
    function startTimer() {
        //timer stop start
        clearInterval(timer);
        timer = setInterval(function() {
            testtime -= 1;
            $("#time").text("TIME LEFT : "+hhmmss(testtime));

            if (testtime == 0) {
                //get all the radio button
                $(".box-body :radio:checked").each(function() {
                    var data = {
                        inputTestQuestionID: $(this).attr('id'),
                        inputAnswer: $(this).attr('value'),
                    };

                    formData.push(data);
                });

                //get all the textarea
                $(".box-body textarea").each(function() {
                    var data = {
                        inputTestQuestionID: $(this).attr('id'),
                        inputAnswer: $(this).val(),
                    };

                    formData.push(data);
                });

                finishTest();
            }
        }, 1000);
    }

    //saving of answer
    function finishTest() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        clearInterval(timer);
        $("#test-list").empty();

        formData = { 
            inputApplicantID: applicantid,
            formData: formData,
        };

        $.ajax({
            type: "POST",
            url: "/admin/transaction/testquestionanswer",
            data: formData,
            dataType: "json",
            success: function(data) {
                console.log(data);
            },
            error: function(data) {
                console.log(data);
            },
        });

        $.ajax({
            type: "POST",
            url: "/admin/transaction/applicantexamstatus",
            data: { inputApplicantID: applicantid },
            success: function(data) {
                console.log(data);
            },
            error: function(data) {
                console.log(data);
            },
        });

        alert("THANKS FOR TESTING");
        window.location.href = "/admin/transaction/testlogin";
    }

    //start of test
    $('#btnStart').click(function() {
        $(this).remove();

        if (applicantid == null) {
            alert("INVALID APPLICANT");
            window.location.href = "/admin/transaction/testlogin";
            return;
        }

        $.ajax({
            type: "GET",
            url: "/admin/transaction/test-check",
            dataType: "json",
            success: function(dataTest) {
                console.log(dataTest);

                $.each(dataTest, function(index, dataTestEach) {
                    console.log(dataTestEach);
                    testtime = Number(dataTestEach.timealloted) + Number(testtime);

                    $.ajax({
                        type: "GET",
                        url: "/admin/transaction/testquestion",
                        data: { inputTestID: dataTestEach.testid, inputMaxQuestion: dataTestEach.maxquestion, },
                        dataType: "json",
                        success: function(dataTestQuestion) {
                            console.log(dataTestQuestion);

                            var row = "<div class='container col-sm-12'>" +
                                "<div class='box box-primary'>" +
                                "<div class='box-body table-responsive'>" +
                                "<h2>"+dataTestEach.name+" Test</h2>" +
                                "<h3>Instruction: "+dataTestEach.instruction+"</h3>" +
                                "<div class='box-body' id='question-list"+dataTestQuestion[0].testid+"'>" +
                                "</div></div></div></div>";
                            $('#test-list').append(row);

                            var num = 1;
                            $.each(dataTestQuestion, function(index, dataTestQuestionEach) {
                                console.log(dataTestQuestionEach);

                                $.ajax({
                                    type: "GET",
                                    url: "/admin/transaction/question",
                                    data: { inputQuestionID: dataTestQuestionEach.questionid },
                                    dataType: "json",
                                    success: function(dataQuestion) {
                                        console.log(dataQuestion);

                                        var row = "<hr><h3>#" + num + ") " + dataQuestion[0].question + "</h3>";
                                        var questionid = dataQuestion[0].questionid;

                                        if (dataQuestion[0].choice.length) {
                                            if(dataQuestion[0].type == 0) {
                                                $.each(dataQuestion[0].choice, function(index, value1) {
                                                    row += "<label>" +
                                                    "<input type='radio' name='rdoGroup"+questionid+"' id="+dataQuestion[0].test_question[0].testquestionid+" value='"+value1.answer+"'>  "+value1.answer+
                                                    "</label><br>";
                                                })
                                            } else if(dataQuestion[0].type == 1) {
                                                row += "<label><input type='radio' name='rdoGroup"+questionid+"' id="+dataQuestion[0].test_question[0].testquestionid+" value='True'> True</label><br>" +
                                                    "<label><input type='radio' name='rdoGroup"+questionid+"' id="+dataQuestion[0].test_question[0].testquestionid+" value='False'> False</label><br>";
                                            } else if(dataQuestion[0].type == 2) {
                                                row += "<textarea id="+dataQuestion[0].test_question[0].testquestionid+" class='form-control' rows='3' required>";
                                            }
                                        } else {
                                            row += "<textarea id="+dataQuestion[0].test_question[0].testquestionid+" class='form-control' rows='3' required>";
                                        }

                                        $('#question-list'+dataTestQuestion[0].testid).append(row);
                                        num++;
                                    },
                                });
                            });
                        },
                    });
                });

                testtime *= 60;
                startTimer();
                $("#btnSubmit").show();
            },
            error: function(data) {
                console.log(data);

                if(data.responseJSON == "NO TEST") {
                    alert("NO TEST FOUND - CONTACT ADMINISTRATOR");
                } else if(data.responseJSON == "NO QUESTION") {
                    alert("NO QUESTION FOUND - CONTACT ADMINISTRATOR");
                }

                window.location.href = "/admin/transaction/testlogin";
            }
        });
    });

    $("#btnSubmit").click(function(e) {
        if ($('#formQuestion').parsley().validate()) {
            e.preventDefault();

            //validate for the radio button choice
            var checked = $(".box-body :radio:checked");
            var groups = [];
            $(".box-body :radio").each(function() {
                if (groups.indexOf(this.name) < 0) {
                    groups.push(this.name);
                }
            });
            if (groups.length != checked.length) {
                var total = groups.length - checked.length;
                var a = total>1?' questions are ':' question is ';

                alert(total + a + 'not answer');
                return;
            }

            //get all the radio button
            $(".box-body :radio:checked").each(function() {
                data = {
                    inputTestQuestionID: $(this).attr('id'),
                    inputAnswer: $(this).attr('value'),
                };

                formData.push(data);
            });

            //get all the textarea
            $(".box-body textarea").each(function() {
                var data = {
                    inputTestQuestionID: $(this).attr('id'),
                    inputAnswer: $(this).val(),
                };

                formData.push(data);
            });

            $('#modalConfirm').modal('show')
        }
    });

    $('#btnConfirm').click(function() {
        finishTest();
    });


});

function pad(str) {
    return ("0"+str).slice(-2);
}

function hhmmss(secs) {
    var minutes = Math.floor(secs / 60);
    secs = secs % 60;
    var hours = Math.floor(minutes/60)
    minutes = minutes % 60;
    return pad(hours)+":"+pad(minutes)+":"+pad(secs);
}