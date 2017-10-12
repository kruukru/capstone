<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DUTY DETAIL ORDER</title>
    <style>
    	html
        {
            font-family: Helvetica;
            font-size: 8.5pt;
        }

        @page
        {
            width: 816px;
            height:1056px;
            margin: 48px;
            text-align: justify;
        }

        .FormData
        {
            text-decoration: underline;
        }

        .Signee
        {
            font-weight: bold;
            text-transform: uppercase;
        }

        #imgLogo
        {
            height:70px;
            margin:0px -10px 0px -10px;
        }

        #header
        {
            align-self: center;
            margin: 0 auto;
        }

        #hdrAgencyName
        {
            margin-top:2px;
            font-size: 14pt;
            font-weight: bold;
        }

        #hdrDetails
        {
            margin-top: -1px;
            font-size: 8pt;
        }

        #header td
        {
            padding:10px 10px 10px 10px;
        }

        #subhead
        {
            width:100%;
            margin: 0px 30px 0px 30px;
        }

        .mainlist
        {
            font-weight: bold;
            margin:0px 20px 0px 20px;
        }

        .sublist
        {
            font-weight: bold;
            list-style-type: lower-alpha;
        }

        .subsublist
        {
            font-weight: bold;
            list-style-type: lower-roman;
        }

        li span
        {
            font-weight:normal;
        }

        li
        {
            margin-top:12px;
        }

        #secutable
        {
            border-collapse: collapse;
            width:105%;
            margin-left:-40px;
            font-size: 8pt;
            text-align: center;
        }

        #secutable th, #secutable td
        {
           border: 1px solid black;
           text-align: center;
           padding:0px 5px 0px 5px;
        }

        #secutable td
        {
            font-weight: normal;
            text-align:left;
            height:8px;
            padding:0px 0px 1px 0px;
        }

        #Signature
        {
            padding-left:55px;
            width:100%;
        }
    </style>
</head>
<body>
	<div id="wrap">
        <table id="header">
            <tr>
                <td>
                    <img src="images/{{$company->logo}}" id="imgLogo"><br/>
                </td>
                <td align="center">
                    <span id="hdrAgencyName">{{$company->name}}</span>
                    <p id="hdrDetails">{{$company->address}}<br/>{{$company->contactno}}</p>
                </td>
            </tr>
        </table>
        <br/>

        <table id="subhead">
            <tr>
                <td>
                    <b>Duty Detail Order No: </b>
                    <span class="FormData">{{$floatnumber->floatnumberid}}</span></td>
                <td>
                    <center><span class="FormData">{{Carbon\Carbon::today()->format('F d, Y')}}</span></center>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <center><b>Date</b></center>
                </td>
            </tr>
        </table>

        <ol class="mainlist">
            <li>
                <span><b>References:</b></span><br/>
                <ol class="sublist">
                    <li>
                        <span> Section 4, Rule VII of the 2003 Revised Implementing Rules and Regulation of RA 5487, as amended; and </span>
                    </li>
                    <li>
                        <span> RA 10591, Comprehensive Firearm and Ammunition Regulation Act. </span>
                    </li>
                </ol>
            </li>

            <li>
                <span> <b>Purpose of Detail: </b> <span class="FormData">{{$purpose}}</span></span>
            </li>

            <li>
                 <span> <b>Durations/ Inclusive Dates of Detailed: </b> <span class="FormData">{{$startdate->format('F d')}} - {{$enddate->format('F d Y')}}</span></span>
            </li>
            <li>
                <span> The following security guards (SGs) are hereby assigned to render post security service duties in place/s indicated and hereby issued agency/company owned firearms (FA's). </span> <br/>
                <br/>
                <table id="secutable">
                    <tr>
                        <th rowspan="2" width="160px">NAME OF GUARDS</th>
                        <th rowspan="2" width="70px">DESIGNATION</th>
                        <th rowspan="2" width="80px">PLACE OF GUARD DUTY</th>
                        <th rowspan="2" width="80px">TIME OF SHIFT</th>
                        <th colspan="4" width="">FIREARMS INFORMATION</th>
                    </tr>
                    <tr>
                        <th>KIND</th>
                        <th>MAKE CAL.</th>
                        <th>FAs Serial No.</th>
                        <th>Validity of FAs License</th>
                    </tr>
                    @foreach ($applicants as $applicant)
                    <tr>
                        <td>{{$applicant->firstname}} {{$applicant->middlename}} {{$applicant->lastname}}</td>
                        <td>Duty Guard</td>
                        <td>{{$applicant->qualificationcheck ? $applicant->qualificationcheck->deploymentsite->sitename : ""}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                </table>
            </li>
            
            <li>
                <span><b>Specific Instructions:</b></span>
                <ol class="sublist">
                    <li>
                        <span>
                            Security Guards in this Duty Detail Order (DDO) must be in Security Guard prescribed uniform and shall carry the issued firearms and when they are in actual performance of guard duty within the compound of the establishment or property of their client in the place and time specified in this DDO.<br>
                        </span>
                    </li>
                    <li>
                        <span>
                            This Duty Detail Order is not a written authority for security guards to carry their issued firearm/s outside the premises of the specified post/station nor shall the firearm/s described herein leave the client post/station. Except under the following circumstances while the security guards are in the following conduction security service duties, a separate DDO shall be issued with the duration of not more than <b>twenty four (24) hours</b>.
                            <ol class="subsublist">
                                <li>
                                    <span>While escorting a big amount of cash or valuables outside its jurisdiction or area of operation with or without the use of armored vehicles.</span>
                                </li>
                                <li>
                                    <span>When transporting agency/company license firearms from agency/company office to post and back for posting for routine replacement of firearms, repair and recall of PSA firearms.</span>
                                </li>
                            </ol>
                        </span>
                    </li>
                    <li>
                        <span>
                            The transport of FA's for routine rotation, posting, repair, etc., beyond 24 hours will require the appropriate transport Permit from FEO.
                        </span>
                    </li>
                    <li>
                        <span>
                            The issued firearm/s to the guards are licensed and a copy must be in the possession of the guards.
                        </span>
                    </li>
                </ol>
            </li>
            <li>
                <span>For strict compliance.</span>
            </li>
        </ol>

        <br><br><br>
        <table id="Signature">
            <tr>
                <td>
                    <span class="Signee">{{Auth::user()->admin->firstname}} {{Auth::user()->admin->middlename}} {{Auth::user()->admin->lastname}}</span><br>{{Auth::user()->admin->position}}
                </td>
                <td>
                    <!-- <span class="Signee">*OP. MAN.*</span><br>
                    Operations Manager -->
                </td>
            </tr>
        </table>
    </div>
</body>
</html>