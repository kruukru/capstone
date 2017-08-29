<!DOCTYPE html>
<html>
	<head>
		<title>Firearm License Expiration Report</title>
		<style>
			div.header
			{
				text-align:center;
				line-height:12px;
				font-size:15px;
			}
			#logo
			{
				width:75px;
				height:75px;
			}
			#txtHeader
			{
				font-weight:bold;
			}
			#title
			{
				line-height:70px;
			}
			
			div.to_from
			{
				padding:30px;
				margin-left:40px;
			}
			#rowLabel
			{
				line-height:30px;
				font-weight:bold;
			}
			#rowData
			{
				line-height:30px;
				text-decoration:underline;
			}
			#rowLabelfooter
			{
				line-height:30px;
				font-weight:bold;
			}
			#rowDatafooter
			{
				line-height:30px;
			}
			#text
			{
				font-size:14px;
				line-height:20px;
			}
			#table1
			{
				padding:5px;
				text-align:center;
				border: 1px solid black;
				border-collapse: collapse;
				margin-left:auto;
				margin-right:auto;
			}
			div.notedby
			{
				padding:30px;
				margin-left:40px;
			}
			div.footer
			{
				padding:10px;
				margin-left:80px;

			}
		</style>
	</head>
	<body>
		<div class="header">
			<img src="images/amcor1.png" id="logo">
			<p id="txtHeader">AMCOR SECURITY & INVESTIGATION AGENCY, INC.</p>
			<p>353 Doña Dolores Building, San Rafael St., Brgy. Plainview, Mandaluyong City</p>
			<h2 id="title">FIREARM LICENSE EXPIRATION REPORT</h2>
		</div>
		<div class="to_from">
			<table>
                <tr>
                    <td id="rowLabel">DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td id="rowData">{{Carbon\Carbon::now()->toDayDateTimeString()}}</td>
                </tr>
                <tr>
                    <td id="rowLabel">TO:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td id="rowData"></td>
                </tr>
				<tr>
                    <td id="rowLabel">FROM:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td id="rowData"></td>
                </tr>
            </table>
			<p id="text">This is to inform that the license of the firearms mentioned below has to be renewed before they reach their date of expiration.</p>
		</div>
			<table id="table1">
				<tr>
					<th id="table1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
					<th id="table1">FIREARM</th>
					<th id="table1">LICENSE NUMBER</th>
					<th id="table1">HANDLER</th>
					<th id="table1">EXPIRATION</th>
				</tr>
				@foreach ($firearms as $firearm)
					<tr id="table1">
						<td id="table1"> </td>
						<td id="table1">{{$firearm->item->name}}</td>
						<td id="table1">{{$firearm->license}}</td>
						<td id="table1"></td>
						<td id="table1">{{$firearm->expiration->format('M. d, Y')}}</td>
					</tr>
				@endforeach
			</table>
			
		<div class="notedby">
			<table>
                <tr>
                    <td id="rowLabelfooter">NOTED BY:</td>
                </tr>
            </table>
		</div>
		<div class="footer">
			<table>
                <tr>
                    <td id="rowLabelfooter">{{Auth::user()->admin->lastname}}, {{Auth::user()->admin->firstname}} {{Auth::user()->admin->middlename}}</td>
                </tr>
				<tr>
					<td id="rowDatafooter">{{Auth::user()->admin->position}}</td>
                </tr>
				
            </table>
		</div>
	</body>
</html>