<!DOCTYPE html>
<html>
<head>
	<style type="text/css">

		html
		{
			font-family: Helvetica;
			font-size: 10pt;
			text-align: center;
			line-height: 14pt;
		}
		@page
        {
            width: 816px;
            height:1056px;
            margin: 48px;
        }

        #imgLogo
        {
        	width: 60px;
        	margin-bottom: -15px;
        }

        #tblHeader
        {
        	text-align: center;
        	width: 100%;
        }

        #tblHeader td
        {
        	padding:5px 0px 5px 0px;
        }

        #details
        {
        	text-decoration: underline;
        	font-weight: bold;
        }

        #tblAttend th, #tblAttend td
        {
        	padding: 2px;
        }

        #formData
        {
        	text-decoration: underline;
        }

        #tblAttend th, #tblAttend td, #tblAttend
        {
        	border: 1px solid black;
        	border-collapse: collapse;
        }

        #tblAttend th
        {
        	text-align: center;
        	font-weight: bold;
        }

        #attendInfo
        {
        	text-transform: uppercase;
        }

        #tblAttendInfo
        {
        	margin-left: 53px;
        	font-size:11px;
        	margin-bottom: 4px;
        }

        #tblAttend
        {
        	margin: 0 auto;
        	width: 80%;
        	font-size: 11px;
        }

        .classInfo, .classData
        {
        	padding: 2px;
        }

        .clientInfo
        {
        	font-weight: bold;
        	width: 50px;
        }

        .clientData
        {
        	padding-left: 10px;
        	width: 500px;
        }

	</style>
	<title>ATTENDANCE</title>
</head>
<body>
	<table id="tblHeader">
		<tr>
			<td>
				<img src="images/amcor1.png" id="imgLogo">
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>
				<span style="font-weight: bold; font-size: 12pt;" >AMCOR SECURITY AND INVESTIGATION AGENCY INC.</span>
				<br>
				<span style="font-size: 8pt;">353 Doña Dolores Bldg., San Rafael St.
Brgy. Plainview, Mandaluyong City</span>
			</td>
		</tr>
	</table>
	<br><br>
	<center>
		<span style="font-weight: bold; font-size: 14pt;"><b>DAILY ATTENDANCE</b></span><br>
		Date: <span id="formData">{{Carbon\Carbon::today()->format('l, M. d, Y')}}</span>
	</center>
	<br><br>


	<table id="tblAttendInfo">
		<tr>
			<td class="clientInfo">CLIENT:</td>
			<td class="clientData" id="formData">{{$deploymentsite->contract->client->contactperson}}</td>
		</tr>
		<tr>
			<td class="clientInfo">DETACHMENT SITE:</td>
			<td class="clientData" id="formData">{{$deploymentsite->sitename}}</td>
		</tr>
	</table>

	<table id="tblAttend">
		<tr id="attendInfo">
			<th></th>
			<th id="attendInfo">SECURITY GUARD NAME</th>
			<th id="attendInfo">ATTENDANCE</th>
		</tr>
    	@foreach ($attendances as $attendance)
            <tr id="attendInfo">
                <td id="attendInfo" style="text-align: center;"></td>
                <td id="attendInfo">{{$attendance->applicant->lastname}}, {{$attendance->applicant->firstname}} {{$attendance->applicant->middlename}}</td>
                <td id="attendInfo" style="text-align: center;">
                    @if ($attendance->status == 0)
                        PRESENT
                    @elseif ($attendance->status == 1)
                        LATE
                    @elseif ($attendance->status == 2)
                        ABSENT
                    @endif
                </td>
            </tr>
        @endforeach
	</table>
</body>
</html>