<!DOCTYPE html>
<html>
<head>
    <title>ATTENDANCE</title>
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
				<img src="images/{{$company->logo}}" id="imgLogo">
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>
				<span style="font-weight: bold; font-size: 12pt;" >{{$company->name}}</span>
				<br>
				<span style="font-size: 8pt;">{{$company->address}}</span>
			</td>
		</tr>
	</table>
	<br><br>
	<center>
		<span style="font-weight: bold; font-size: 14pt;"><b>SUMMARY OF ATTENDANCE</b></span><br>
		Date: <span id="formData">{{Carbon\Carbon::today()->format('F d, Y')}}</span>
	</center>
	<br><br>


	<table id="tblAttendInfo">
		<tr>
			<td class="clientInfo">CLIENT:</td>
			<td class="clientData" id="formData">{{$applicant->attendance[0]->deploymentsite->contract->client->company}}</td>
		</tr>
		<tr>
			<td class="clientInfo">DETACHMENT SITE:</td>
			<td class="clientData" id="formData">{{$applicant->attendance[0]->deploymentsite->sitename}}</td>
		</tr>
		<tr>
			<td class="clientInfo">SECURITY GUARD:</td>
			<td class="clientData" id="formData">{{$applicant->firstname}} {{$applicant->middlename}} {{$applicant->lastname}}</td>
		</tr>
        <tr>
            <td class="clientInfo">DATE:</td>
            <td class="clientData" id="formData">{{$startdate->format('F d, Y')}} - {{$enddate->format('F d, Y')}}</td>
        </tr>
	</table>
	<br>
	<table id="tblAttend">
		<tr id="attendInfo">
			<th id="attendInfo">DATE</th>
			<th id="attendInfo" style="width: 80px">TIME IN</th>
			<th id="attendInfo" style="width: 80px">TIME OUT</th>
			<th id="attendInfo" style="width: 80px">REMARKS</th>
		</tr>
        @foreach ($attendances as $attendance)
            <tr id="attendInfo">
                <td id="attendInfo">{{$attendance->date->format('d F Y')}}</td>
                <td id="attendInfo" style="text-align: center;">{{$attendance->timein}}</td>
                <td id="attendInfo" style="text-align: center;">{{$attendance->timeout}}</td>
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