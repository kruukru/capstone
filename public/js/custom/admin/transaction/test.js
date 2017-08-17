$(document).ready(function() {
    var applicantid = window.localStorage.getItem("applicantid");
    localStorage.removeItem("applicantid");

    var testid = [], testname = [], testinstruction = [], testmaxquestion = [], testtime = [], formData = [];
    var testmin = 0, testmax = 0;
    var questionmax = 0;
    var timer = null;

    //next test
    function nextTest() {
        if(testmin != testmax) {
            //start init
            $("#btnSubmit").show();
            $("#time").text(testtime[testmin] * 60);
            $('#testName').text(testname[testmin] + " Test");
            $('#testInstruction').text("Instruction: " + testinstruction[testmin]);

            //timer stop start
            clearInterval(timer);
            timer = setInterval(function() {
                $("#time").text($("#time").text() - 1);

                if($("#time").text() == 0) {
                    //get all the radio button
                    $("#question-list :radio:checked").each(function() {
                        var data = {
                            inputApplicantID: applicantid,
                            inputTestQuestionID: $(this).attr('id'),
                            inputAnswer: $(this).attr('value'),
                        };

                        formData.push(data);
                    });

                    //get all the textarea
                    $("#question-list textarea").each(function() {
                        var data = {
                            inputApplicantID: applicantid,
                            inputTestQuestionID: $(this).attr('id'),
                            inputAnswer: $(this).val(),
                        };

                        formData.push(data);
                    });

                    $("#question-list").empty();
                    nextTest();
                }
            }, 1000);

            $.ajax({
                type: "GET",
                url: "/admin/transaction/testquestion",
                data: { inputTestID: testid[testmin], inputMaxQuestion: testmaxquestion[testmin], },
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var num = 1;
                    $.each(data, function(index, value) {
                        console.log(value);

                        $.ajax({
                            type: "GET",
                            url: "/admin/transaction/question",
                            data: { inputQuestionID: value.questionid },
                            dataType: "json",
                            success: function(data) {
                                console.log(data);

                                var row = "<hr><h3>#" + num + ") " + data[0].question + "</h3>";
                                var questionid = data[0].questionid;

                                if(data[0].choice.length) {
                                    if(data[0].type == 0) {
                                        $.each(data[0].choice, function(index1, value1) {
                                            row += "<label>" +
                                            "<input type='radio' name='rdoGroup"+questionid+"' id="+data[0].test_question[0].testquestionid+" value='"+value1.answer+"'>  "+value1.answer+
                                            "</label><br>";
                                        })
                                    } else if(data[0].type == 1) {
                                        row += "<label><input type='radio' name='rdoGroup"+questionid+"' id="+data[0].test_question[0].testquestionid+" value='True'> True</label><br>" +
                                            "<label><input type='radio' name='rdoGroup"+questionid+"' id="+data[0].test_question[0].testquestionid+" value='False'> False</label><br>";
                                    } else if(data[0].type == 2) {
                                        row += "<textarea id="+data[0].test_question[0].testquestionid+" class='form-control' rows='3' required>";
                                    }
                                } else {
                                    row += "<textarea id="+data[0].test_question[0].testquestionid+" class='form-control' rows='3' required>";
                                }

                                $('#question-list').append(row);
                                num++;
                            },
                            error: function(data) {
                                console.log(data);
                            },
                        });
                    });
                },
                error: function(data) {
                    console.log(data);
                },
            });

            testmin++;
        } else { //end of test
            clearInterval(timer);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            formData = { formData: formData };
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
    }

    //start of test/new test
    $('#btnStart').click(function() {
        $(this).remove();

        $.ajax({
            type: "GET",
            url: "/admin/transaction/test-check",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    console.log(value);

                    testid[testmax] = value.testid;
                    testname[testmax] = value.name;
                    testinstruction[testmax] = value.instruction;
                    testmaxquestion[testmax] = value.maxquestion;
                    testtime[testmax] = value.timealloted;
                    testmax++;
                });

                nextTest();
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
        if($('#formQuestion').parsley().isValid()) {
            e.preventDefault();

            //validate for the radio button choice
            var checked = $("#question-list :radio:checked");
            var groups = [];
            $("#question-list :radio").each(function() {
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
            $("#question-list :radio:checked").each(function() {
                data = {
                    inputApplicantID: applicantid,
                    inputTestQuestionID: $(this).attr('id'),
                    inputAnswer: $(this).attr('value'),
                };

                formData.push(data);
            });

            //get all the textarea
            $("#question-list textarea").each(function() {
                var data = {
                    inputApplicantID: applicantid,
                    inputTestQuestionID: $(this).attr('id'),
                    inputAnswer: $(this).val(),
                };

                formData.push(data);
            });

            $("#question-list").empty();
            nextTest();
        }
    });
});