<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        #imgLogo {
            width: 70px;
        }

        ul {
            line-height: 22px;
        }

        #mainLeftCell
        {
            padding:10px;
        }

        #mainRightCell {
            font-family: Helvetica;
            line-height: 10px;
            //border-left: 1px solid gray;
        }

        #pSubHD {
            font-weight:100;
            font-size: 11px;
        }

        #compName
        {
            font-size: 23px;
        }

        #titleHD {
            color:#072e56;
            font-size: 18pt;
        }

        fieldset{
            border:0.2pt solid gray;
            border-left:0px;
            border-right:0px;
            line-height: 14px;
            padding-top: -5px;
        }

        #rowLabel {
            width:140px;
            font-weight: 400;
            font-size: 14px;
        }

        #rowData {
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            width:120px;
        }

        #pData
        {
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
        }

        #rowData, #rowLabel, #rowData1{
            padding-right: 10px;
        }

        #rowData1
        {
            font-weight: 700;
            font-size: 14px;
            width:350px;
            text-transform: uppercase;
        }

        #signBox {
            border-style: solid;
            border-color: gray;
            border-width: 1px;
            width:450px;
            height: 25px;
            margin-left:10px;
        }

        #pDetails {
            text-indent: 5%; 
            font-size:9pt;
            line-height:16px;
        }

        #pSign
        {
            font-size:9pt;
            line-height:16px;
        }

        #hrCut { 
            border-top: 1px dashed #8c8b8b;
        } 

        html
        {
             font-family: Helvetica;
        }
    </style>
</head>
<body>
    <div id="wrap">
        <div id="wrapIn">
            <table>
                <tr>
                    <td id="mainLeftCell">
                        <img src="images/amcor.png" id="imgLogo">
                    </td>
                    <td id="mainRightCell">
                        <h2 id="compName">AMCOR SECURITY AND INVESTIGATION AGENCY, INC.</h2>
                        <p id="pSubHD">
                            353 DOÑA DOLORES BUILDING, SAN RAFAEL ST., BRGY. PLAINVIEW, MANDALUYONG CITY
                        </p>
                    </td>
                </tr>
                <tr>
                    <td id="mainLeftCell1">
                    </td>
                    <td id="mainRightCell">
                        <h2 id="titleHD">APPOINTMENT VOUCHER</h2>
                        <fieldset>
                            <table>
                            <tr>
                                <td id="rowLabel">APPLICANT NAME</td>
                                <td id="rowData1"><p id="pData">{{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}</p></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td id="rowLabel">APPLICANT NO</td>
                                <td id="rowData">{{$applicant->applicantid}}</td>
                                <td id="rowLabel">APPOINTMENT NO</td>
                                <td id="rowData">{{$appointment->appointmentid}}</td>
                            </tr>
                            <tr>
                                <td id="rowLabel">REGISTRATION DATE</td>
                                <td id="rowData">{{$applicant->created_at->format('D, M. d, Y')}}</td>
                                <td id="rowLabel">APPOINTMENT DATE</td>
                                <td id="rowData">{{$appointment->appointmentdate->date->format('D, M. d, Y')}}</td>
                            </tr>
                            </table>
                        </fieldset>
                        
                        <p id="pDetails">This is the agency’s   copy. Detach this part and present to the agency’s receptionist before going to the Assessment Phase.
                        </p>
                        <p id="pDetails">This will serve as a proof that you have registered in the agency’s website and have scheduled an appointment. Be reminded that you cannot be able to undergo Assessment and Interview without this voucher.</p>
                        <p id="pDetails">I expressly agree to the Terms of Use and confirm that the information that I have
provided to the Agency are true and correct to the best of my knowledge..</p>
                        <br>
                        <table>
                            <tr>
                                <td id="pSign">
                                  <b>APPLICANT'S SIGNATURE<b>
                                </td>
                                <td id="signBox">

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        
        <br/><br/>
        </div>
        <hr id="hrCut">
        <br/>
        <div id="wrapIn">
            <table>
                <tr>
                    <td id="mainLeftCell">
                        <img src="images/amcor.png" id="imgLogo">
                    </td>
                    <td id="mainRightCell">
                        <h2 id="compName">AMCOR SECURITY AND INVESTIGATION AGENCY, INC.</h2>
                        <p id="pSubHD">
                            353 DOÑA DOLORES BUILDING, SAN RAFAEL ST., BRGY. PLAINVIEW, MANDALUYONG CITY
                        </p>
                    </td>
                </tr>
                <tr>
                    <td id="mainLeftCell1">
                    </td>
                    <td id="mainRightCell">
                        <h2 id="titleHD">APPOINTMENT VOUCHER</h2>
                        <fieldset>
                            <table>
                            <tr>
                                <td id="rowLabel">APPLICANT NAME</td>
                                <td id="rowData1"><p id="pData">{{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}</p></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td id="rowLabel">APPLICANT NO</td>
                                <td id="rowData">{{$applicant->applicantid}}</td>
                                <td id="rowLabel">APPOINTMENT NO</td>
                                <td id="rowData">{{$appointment->appointmentid}}</td>
                            </tr>
                            <tr>
                                <td id="rowLabel">REGISTRATION DATE</td>
                                <td id="rowData">{{$applicant->created_at->format('D, M. d, Y')}}</td>
                                <td id="rowLabel">APPOINTMENT DATE</td>
                                <td id="rowData">{{$appointment->appointmentdate->date->format('D, M. d, Y')}}</td>
                            </tr>
                            </table>
                        </fieldset>

                        <p id="pDetails">This is your copy. Keep this secured for possible future  validations.
                        </p>
                        <p id="pDetails">This will serve as a proof that you have registered in the agency’s website and have scheduled an appointment.</p>

                        <br>
                        <table>
                            <tr>
                                <td id="pSign">
                                    <b>APPLICANT'S SIGNATURE<b>
                                </td>
                                <td id="signBox">

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>
        <div id="wrap1">
        <br/>
            <h3>REMINDERS!</h3>
            <ul>
                <li><b>Be on Time.</b> Be at the agency an hour or at least 30 minutes ahead of your appointment time to avoid encountering problems.</li>
                <li><b>Be well-groomed.</b> Wear an appropriate attire- a pair of black shoes and complete security guard attire.</li>
                <li><b>Prepare your credentials.</b> Do not forget to bring all the required credentials needed. To be fully guided, you can use the list of the things needed:
                    <ul>
                        @foreach ($applicantrequirements as $applicantrequirement)
                            <li>{{$applicantrequirement->requirement->name}}</li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>