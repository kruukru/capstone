<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>MONTHLY DISPOSITION REPORT</title>
    <style>
    	html
        {
            font-family: Helvetica;
            font-size: 7pt;
        }

        @page
        {
            width: 1056px;
            height:816px;
            margin: 48px;
            text-align: justify;
        }

        #header
        {
            font-size: 8pt;
        }

        #salutations
        {
            font-size: 7pt;
            margin-left: -5px;
        }

        #agencyName
        {
            font-weight: bold;
            text-transform: uppercase;
        }

        #agencyLTO
        {
            color: blue;
            text-transform: uppercase;
        }

        #mainTable
        {
            width: 100%;
            border-collapse: collapse;
        }

        #mainTable th
        {
            text-align: center;
        }

        #mainTable th, #mainTable td
        {
            border: 1px solid black;
            padding-left: 5px;
        }
    </style>
</head>
<body>
	<div id="wrap">
        <table width="100%">
            <tr>
                <td align="center">
                    <div id="header">
                        <span id="agencyName">{{$company->name}}</span><br>
                        <span id="agencyInfo">{{$company->address}}<br>{{$company->contactno}}<br>{{$company->license}}</span><br>
                        <span id="agencyLTO">LTO EXPIRES ON {{$company->expiration->format('d F Y')}}</span><br>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                   <table id="salutations">
                        <tr>
                            <th>TO:</th>
                            <td width="100%">SOSIA</td>
                        </tr>
                        <tr>
                            <th>SUBJECT:</th>
                            <td>MONTHLY DISPOSITION REPORT</td>
                        </tr>
                        <tr>
                            <th>DATE</th>
                            <td width="100%" style="text-transform: uppercase;">{{Carbon\Carbon::today()->format('F d, Y')}}</td>
                        </tr>
                        <tr>
                            <th>EMAIL ADDRESS:</th>
                            <td>{{$company->email}}</td>
                        </tr>
                    </table> 
                </td>
            </tr>
        </table>

        <br><br>

        <b>DEAR SIR/MADAM:</b>

        <br><br>

        Respectfully submitted herewith is the disposition of our clients, firearms, security guards and their respective insurance policy for the Month of {{Carbon\Carbon::today()->format('F Y')}}
        <br><br>
        <table id="mainTable">
            <tr>
                <th>CLIENT</th>
                <th></th>
                <th></th>
                <th colspan="3">NAME OF OFFICERS/GUARDS</th>
                <th>EDUC</th>
                <th>LICENSE</th>
                <th>EXPIRY</th>
                <th>SSS NO.</th>
                <th></th>
                <th colspan="3">FIREARMS</th>
                <th>SSS MO.</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>FIRST</th>
                <th>MIDDLE</th>
                <th>LAST</th>
                <th>ATTAINMENT</th>
                <th>NUMBER</th>
                <th>DATE</th>
                <th></th>
                <th># PCS</th>
                <th>MAKE</th>
                <th>TYPE</th>
                <th>SERIAL</th>
                <th>Cont.</th>
            </tr>
            @foreach ($contracts as $contract)
                @foreach ($contract->deploymentsite->qualificationcheck as $qualificationcheck)
                <tr>
                    <td>{{$contract->client->company}} - {{$contract->deploymentsite->sitename}}</td>
                    <td></td>
                    <td></td>
                    <td>{{$qualificationcheck->applicant->firstname}}</td>
                    <td>{{$qualificationcheck->applicant->middlename}}</td>
                    <td>{{$qualificationcheck->applicant->lastname}}</td>
                    <td>
                        @foreach ($qualificationcheck->applicant->educationbackground as $educationbackground)
                            {{$educationbackground->graduatetype}}
                        @endforeach
                    </td>
                    <td>{{$qualificationcheck->applicant->license}}</td>
                    <td>{{$qualificationcheck->applicant->licenseexpiration->format('M. d Y')}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            @endforeach
        </table>
    </div>
</body>
</html>