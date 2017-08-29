<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Equipment Tracking Report</title>
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

        #header
        {
            width: 100%;
            border-collapse: collapse;
        }


        #hdrLeft
        {
            line-height: 15px;
            width:350px;
        }

        #hdrRight
        {
            border: 1px solid darkgray;
            line-height: 12px;
            font-size: 10px;
            width: 300px;
            padding:5px;
        }

        #hdrLogo
        {
            width: 70px;
        }

        #detachInfo
        {
            text-decoration: underline;
            font-weight: normal;
            text-transform: uppercase;
        }

        #hdrAgencyName
        {
            margin-top:2px;
            font-size: 8pt;
            font-weight: bold;
        }

        #hdrDetails
        {
            margin-top: -1px;
            font-size: 7pt;
        }

        #imgLogo
        {
            height:45px;
            margin:-8px 0px 0px 10px;
        }

        #mainTable
        {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            border-bottom: .9pt solid black;
        }

        #mainTable th
        {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            border: .9pt solid black;
        }

        #mainTable #itemName
        {
            font-weight: bold;
        }

        #mainTable td
        {
            border-bottom: .2pt solid black;
            border-right: .9pt solid black;
            border-left: .9pt solid black;
        }
        #Sign
        {
            font-size: 9px;
            margin-left: 350px;
        }
    </style>
</head>
<body>
	<div id="wrap">
        <table id="header">
            <tr>
                <td id="hdrLogo"> 
                    <img src="images/amcor1.png" id="imgLogo">
                <td id="hdrLeft">
                    <span id="hdrAgencyName">AMCOR SECURITY & INVESTIGATION AGENCY, INC.</span><br>
                    <p id="hdrDetails">353 Doña Dolores Building, San Rafael St., Brgy. Plainview, Mandaluyong City<br/>*AGENCY TELEPHONE/ CONTACT NUMBER*</p>
                </td>
                <td>
                    <table id="hdrRight">
                    <tr>
                        <td width="50px;">
                            <b>DETACHMENT: </b>
                        </td>
                        <td>
                            <span id="detachInfo">*Sta. Rosa, Laguna Plant!*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>DATE:</b>
                        </td>
                        <td>
                            <span id="detachInfo">*DATE*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>SUBJECT:</b>
                        </td>
                        <td>
                            <span id="detachInfo">*SUBJECT*</span>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
        </table>
        <br><br>
        <table id="mainTable">
            <tr>
                <th>NAME</th>
                <th>ITEM TYPE</th>
                <th style="width:30px;">QTY</th>
                <th>SERIAL NUMBER/S</th>
                <th>DATE ISSUED</th>
                <th>REMARKS</th>
            </tr>
            @foreach ($items as $item)
                <tr>
                    <td id="itemName">{{$item->name}}</td>
                    <td>{{$item->itemtype->name}}</td>
                    <td>{{$item->qty}}</td>
                    <td>**</td>
                    <td>**</td>
                    <td>**</td>
                </tr>
            @endforeach
        </table>
        <br><br>
        <table id="Sign">
            <tr>
                <td>
                    <b>PREPARED BY: </b>
                </td>
                <td align="center">
                    <span id="detachInfo">*DEPCOMM NAME*</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="center"><b>DEPUTY COMMANDER</b></td>
            </tr>
        </table>
    </div>
</body>
</html>