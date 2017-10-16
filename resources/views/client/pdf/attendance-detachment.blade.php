<!DOCTYPE html>
<html>
<head>
	<title>ATTENDANCE</title>
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
            margin: 48px;
        }

        #imgLogo
        {
        	width: 60px;
        }

        #tblHeader
        {
        	text-align: center;
        	width: 100%;
        }
        #tblSiteDetails
        {
        	font-size: 10pt;
        	width: 100%;
        }
        #title
        {
        	font-size: 24pt;
        	font-weight: bold;
        	color: #1d335d;
        }
        #tblAttendance
        {
        	border:1px solid black;
			border-collapse: collapse;
        	width: 100%;
        	font-size:10pt;
        }
        #tblAttendance th, #tblAttendance td
        {
        	border:1px solid black;
        	border-collapse: collapse;
        }
        #tblAttendance th
        {
        	text-align: center;
        }
        </style>
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
				<span style="font-weight: bold; font-size: 14pt;" >{{$company->name}}</span>
				<br>
				<span style="font-size: 10pt;">{{$company->address}}</span>
			</td>
		</tr>
		<tr>
			<td>
				<span id="title">ATTENDANCE SUMMARY</span>
			</td>
		</tr>
	</table>
	<br>
	<table id="tblSiteDetails">
		<tr>
			<td><b>DETACHMENT SITE: </b><span id="data">{{$deploymentsite->sitename}}, {{$deploymentsite->location}}</span></td>
			<td><b>DURATION: </b><span id="data">{{$startdate->format('F d, Y')}} - {{$enddate->format('F d, Y')}}</span></td>
		</tr>
		<tr>
			<td><b>FOR THE MONTH OF: {{$startdate->format('F')}}</b></td>
			<td><b>LEGENDS: </b>
				<b>P</b> - PRESENT  |
				<b>L</b> - LATE  |
				<b>A</b> - ABSENT  
			</td>
		</tr>
	</table>

		
	<br>
	<table id="tblAttendance">
		<tr>
			<th style="width: 200px;">NAME</th>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
			<th>6</th>
			<th>7</th>
			<th>8</th>
			<th>9</th>
			<th>10</th>
			<th>11</th>
			<th>12</th>
			<th>13</th>
			<th>14</th>
			<th>15</th>
			<th>16</th>
			<th>17</th>
			<th>18</th>
			<th>19</th>
			<th>20</th>
			<th>21</th>
			<th>22</th>
			<th>23</th>
			<th>24</th>
			<th>25</th>
			<th>26</th>
			<th>27</th>
			<th>28</th>
			<th>29</th>
			<th>30</th>
			<th>31</th>
			<th style="width: 30px;">PRESENTS</th>
			<th style="width: 30px;">LATES</th>
			<th style="width: 30px;">ABSENTS</th>
		</tr>
		@foreach ($collection as $collect)
			<tr>
				<td style="text-transform: uppercase;">{{$collect['name']}}</style></td>
				<td>{{$collect['d1']}}</td>
				<td>{{$collect['d2']}}</td>
				<td>{{$collect['d3']}}</td>
				<td>{{$collect['d4']}}</td>
				<td>{{$collect['d5']}}</td>
				<td>{{$collect['d6']}}</td>
				<td>{{$collect['d7']}}</td>
				<td>{{$collect['d8']}}</td>
				<td>{{$collect['d9']}}</td>
				<td>{{$collect['d10']}}</td>
				<td>{{$collect['d11']}}</td>
				<td>{{$collect['d12']}}</td>
				<td>{{$collect['d13']}}</td>
				<td>{{$collect['d14']}}</td>
				<td>{{$collect['d15']}}</td>
				<td>{{$collect['d16']}}</td>
				<td>{{$collect['d17']}}</td>
				<td>{{$collect['d18']}}</td>
				<td>{{$collect['d19']}}</td>
				<td>{{$collect['d20']}}</td>
				<td>{{$collect['d21']}}</td>
				<td>{{$collect['d22']}}</td>
				<td>{{$collect['d23']}}</td>
				<td>{{$collect['d24']}}</td>
				<td>{{$collect['d25']}}</td>
				<td>{{$collect['d26']}}</td>
				<td>{{$collect['d27']}}</td>
				<td>{{$collect['d28']}}</td>
				<td>{{$collect['d29']}}</td>
				<td>{{$collect['d30']}}</td>
				<td>{{$collect['d31']}}</td>
				<td>{{$collect['present']}}</td>
				<td>{{$collect['late']}}</td>
				<td>{{$collect['absent']}}</td>
			</tr>
		@endforeach
	</table>
</body>
</html>