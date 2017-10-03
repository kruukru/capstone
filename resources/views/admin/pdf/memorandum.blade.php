<!DOCTYPE html>
<html>
<head>
	<style type="text/css">

		html
		{
			
		}
		@page
        {
            width: 816px;
            height:1056px;
            margin: 48px;

            font-family:Arial;
			font-size: 10pt;
        }

        #imgLogo
        {
        	width: 50px;

        }

        #txtHeader
        {
        	font-weight: bold;
        	font-size: 13pt;
        }

        #tblHeader
        {
        	width: 100%;
        }

        #tblHeader tr
        {
        	text-align: center;
        }

        #tblInfo td
        {
        	padding:10px 0px 10px 0px;
        }
        #txtAdminName, #txtMemoNo, #txtLetterInfo
        {
        	font-weight: bold;
        	text-transform: uppercase;
        }
	</style>
	<title>MEMORANDUM</title>
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
			<td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>
				<span id="txtHeader">M    E    M    O    R    A    N    D    U    M</span>
			</td>
		</tr>
	</table>

	<br><br>
	MEMO No. <b><span id="txtMemoNo">1</span></b>
	<br><br>

	<table id="tblInfo">
		<tr>
			<td>
				TO              :
			</td>
			<td>
				@foreach ($applicants as $applicant)
					<span id="txtLetterInfo">{{$applicant->firstname}} {{$applicant->middlename}} {{$applicant->lastname}}<br>-{{$applicant->qualificationcheck->deploymentsite->sitename}}<br><br></span>
				@endforeach
			</td>
		</tr>
		<tr>
			<td>
				FROM            :
			</td>
			<td>
				<span id="txtLetterInfo">{{Auth::user()->admin->position}}</span>
			</td>
		</tr>
		<tr>
			<td>
				DATE            :
			</td>
			<td>
				<span id="txtLetterInfo">{{Carbon\Carbon::today()->format('F d, Y')}}</span>
			</td>
		</tr>
		<tr>
			<td>
				SUBJECT         :
			</td>
			<td>
				<span id="txtLetterInfo">{{$subject}}</span>
			</td>
		</tr>
	</table>

	<br><br>
	<hr>
	<br><br>

	<span id="txtBody">
		{{$memorandumbody}}
	</span>

	<br><br>

	Prepared By:
	<br><br><br><br>

	<span id="txtAdminName">
		{{Auth::user()->admin->firstname}} {{Auth::user()->admin->middlename}} {{Auth::user()->admin->lastname}}
	</span>
	<br>
	<span>
		{{Auth::user()->admin->position}}
	</span>
</body>
</html>