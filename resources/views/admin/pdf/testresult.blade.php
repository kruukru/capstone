<html>
	<head>
		<title>Test Result</title>
		<style>
			body
			{
				border:1px solid black;
			}
			div.test
			{
				padding:30px;
				margin-left:5px;
			}
			#logo
			{
				width:75px;
				height:75px;
				margin-top:30px;
				margin-left:30px;	
				position:absolute;
			}
			#txtHeader
			{
				font-weight:bold;
				font-size:22px;
				font-family:helvetica;
				line-height:15px;
				margin-top:45px;
				margin-left:120px;
			}
			#txtSub
			{
				font-size:15px;
				font-family:helvetica;
				line-height:10px;
				margin-top:20px;
				margin-left:120px;
			}
			#title
			{
				line-height:50px;
				font-size:24px;
				font-family:helvetica;
				font-color:#072e56;
				text-align:center;
			}
			#rowLabel
			{
				line-height:20px;
				font-weight:bold;
			}
			#rowData
			{
				line-height:20px;
				
			}
			#TestForm
			{
				padding:5px;
				text-align:center;
				border: 1px ridge black;
				border-collapse: collapse;
				margin-left:auto;
				margin-right:auto;
				width:125px;
			}
			#applicant
			{
				line-height:50px;
				font-size:24px;
				font-color:#072e56;
				margin-left:5px;
			}
		</style>
	</head>
	<body>
		<div class="header">
			<img src="images/{{$company->logo}}" id="logo">
			<p id="txtHeader">{{$company->name}}</p>
			<p id="txtSub">{{$company->address}}</p>
		<div class="test">
		<h2 id="applicant">APPLICANT DETAILS</h2>
		<fieldset>
			<table id="test">
				<tr>
					<td id="rowLabel">APPLICANT NAME:</td>
					<td id="rowData">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}</td>
				</tr>
				<tr>
					<td id="rowLabel">APPLICANT NUMBER:</td>
					<td id="rowData">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$applicant->applicantid}}</td>
				</tr>
				<tr>
					<td id="rowLabel">EXAMINATION DATE:</td>
					<td id="rowData">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$scores[0]->created_at->format('Y-m-d')}}</td>
				</tr>
			</table>
		</fieldset>
		</div>
		</br>
		</br>
		<h2 id="title">TEST RESULTS</h2>
		<table id="TestForm">
			<tr>
				<th id="TestForm">Test Form</th>
				<th id="TestForm">Score</th>
				<th id="TestForm">Number of Items</th>
				<th id="TestForm">Percentage</th>
				<th id="TestForm">Status</th>
			</tr>
			@foreach ($scores as $score)
				<tr id="TestForm">
					<td id="TestForm">{{$score->test->name}}</td>
					<td id="TestForm">{{$score->score}}</td>
					<td id="TestForm">{{$score->item}}</td>
					<td id="TestForm">{{number_format(($score->score / $score->item) * 100, 2, '.', ',')}}%</td>
					<td id="TestForm">{{($score->score / $score->item) * 100 >= 75 ? "PASSED" : "FAILED"}}</td>
				</tr>
			@endforeach
		</table>
	</body>
</html>