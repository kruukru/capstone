<!DOCTYPE html>
<html>
<head>
	<style type="text/css">

		html
		{
			font-family: Helvetica;
			font-size: 14pt;
			text-align: center;
			line-height: 23pt;
		}
		@page
        {
            width: 816px;
            height:1056px;
            margin: 84px;
        }

        #imgLogo
        {
        	width: 70px;
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

	</style>
	<title>CERTIFICATE</title>
</head>
<body>
	@foreach ($applicants as $applicant)
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
					<span style="font-weight: bold; font-size: 14pt;" >{{$company->name}}</span>
					<br>
					<span style="font-size: 10pt;">{{$company->address}}</span>
				</td>
			</tr>
		</table>

		<br>
		This
		<br><br>
		<span style="font-weight: bold; font-size: 26pt; color:#223683;" >CERTIFICATE OF RECOGNITION</span>
		<br><br>
		is hereby presented to
		<br><br>
		<span style="font-weight: bold; font-size: 29pt;font-color:#223683;">{{$applicant->firstname}} {{$applicant->middlename}} {{$applicant->lastname}}</span>
		<br><br>
		for being <span id="details">{{$certificatedescription}}</span>.<br>
		Awarded in the <span id="details">{{Carbon\Carbon::today()->format('jS')}}</span> of <span id="details">{{Carbon\Carbon::today()->format('F')}}</span>, <span id="details">{{Carbon\Carbon::today()->format('Y')}}</span>.
		<br><br><br><br>
		Signed By:
		<br><br><br><br>
		<span style="font-weight: bold; font-size: 17px;">{{Auth::user()->admin->firstname}} {{Auth::user()->admin->middlename}} {{Auth::user()->admin->lastname}}</span><br>
		<span style="font-size: 17px;">{{Auth::user()->admin->position}}</span><br><br><br><br><br>
	@endforeach
</body>
</html>