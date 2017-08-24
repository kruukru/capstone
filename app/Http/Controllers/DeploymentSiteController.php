<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\DeploymentSite;
use Amcor\ClientQualification;
use Amcor\Contract;
use Amcor\Deploy;
use Amcor\QualificationCheck;
use Amcor\Applicant;
use Amcor\IssuedItem;
use Amcor\IssuedFirearm;
use Geotools;
use Response;
use Auth;
use DB;

class DeploymentSiteController extends Controller
{
    public function getClientDeploymentSite() {
        $deploymentsites = DeploymentSite::whereHas('contract', function($query) {
            $query->where('clientid', Auth::user()->client->clientid);
        })->get();

    	return view('client.deploymentsite', compact('deploymentsites'));
    }

    public function getClientQualificationValidate(Request $request) {
        if (!($request->inputMinAge <= $request->inputPreferAge && $request->inputMaxAge >= $request->inputPreferAge)) {
            return Response::json("INVALID AGE", 500);
        }
        if (!($request->inputMinHeight <= $request->inputPreferHeight && $request->inputMaxHeight >= $request->inputPreferHeight)) {
            return Response::json("INVALID HEIGHT", 500);
        }
        if (!($request->inputMinWeight <= $request->inputPreferWeight && $request->inputMaxWeight >= $request->inputPreferWeight)) {
            return Response::json("INVALID WEIGHT", 500);
        }

        return Response::json("SUCCESS", 200);
    }

    public function postClientQualificationNew(Request $request) {
    	$deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);

        foreach($request->formData as $data) {
            $clientqualification = new ClientQualification;
            $clientqualification->deploymentsite()->associate($deploymentsite);
            $clientqualification->requireno = $data['inputRequireNo'];
            $clientqualification->gender = rtrim($data['inputGender'], ",");
            $clientqualification->attainment = rtrim($data['inputAttainment'], ",");
            $clientqualification->civilstatus = rtrim($data['inputCivilStatus'], ",");
            $clientqualification->age = $data['inputAge'];
            $clientqualification->height = $data['inputHeight'];
            $clientqualification->weight = $data['inputWeight'];
            $clientqualification->workexp = $data['inputWorkExp'];
            $clientqualification->save();
        }

        $deploymentsite->status = 1;
        $deploymentsite->save();

    	return Response::json($deploymentsite);
    }

    public function getClientSecurityGuardList(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        $deploy = Deploy::where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['requestid', null],
        ])->first();
        $clientqualifications = ClientQualification::where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['requestid', null],
        ])->get();

        $requireno = 0;
        foreach ($clientqualifications as $clientqualification) {
            $requireno += $clientqualification->requireno;
        }

        $qualificationchecks = QualificationCheck::where('deployid', $deploy->deployid)->get();
        $pool = collect();
        foreach ($qualificationchecks as $qualificationcheck) {
            $securityguard = Applicant::find($qualificationcheck->applicantid);

            $distance = null;
            if (!($deploymentsite->longitude == null || $deploymentsite->latitude == null || $securityguard->longitude == null || $securityguard->latitude == null)) {
                $coordA = Geotools::coordinate([$deploymentsite->latitude, $deploymentsite->longitude]);
                $coordB = Geotools::coordinate([$securityguard->latitude, $securityguard->longitude]);
                $distance = Geotools::distance()->setFrom($coordA)->setTo($coordB)->in('km')->haversine();
            }

            $pool->push([
                'applicantid' => $securityguard->applicantid,
                'name' => $securityguard->lastname . ", " . $securityguard->firstname . " " . $securityguard->middlename,
                'workexp' => $securityguard->workexp,
                'distance' => $distance,
            ]);
        }

        $dataArray = array(
            'requireno' => $requireno,
            'pool' => $pool,
        );

        return Response::json($dataArray);
    }

    public function postClientSecurityGuardList(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        $deploy = Deploy::where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['requestid', null],
        ])->first();

        foreach ($request->formData as $data) {
            $applicant = Applicant::find($data['inputApplicantID']);

            if ($data['inputStatus'] == 'Accept') {
                $data['inputStatus'] = 1;
                $applicant->status = 10;
                $applicant->save();
            } else if ($data['inputStatus'] == 'Decline') {
                $data['inputStatus'] = 2;
                $applicant->status = 8;
                $applicant->save();
            }

            $qualificationcheck = QualificationCheck::where([
                ['applicantid', $data['inputApplicantID']],
                ['deployid', $deploy->deployid],
            ])->first();

            $qualificationcheck->status = $data['inputStatus'];
            $qualificationcheck->save();
        }

        $deploymentsite->status = 3;
        $deploymentsite->save();

        return Response::json($deploymentsite);
    }

    public function getClientItemGet(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        $deploy = Deploy::where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['requestid', null],
        ])->first();

        $issueditem = IssuedItem::with('item.itemtype')->where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['deployid', $deploy->deployid],
        ])->get();

        return Response::json($issueditem);
    }

    public function getClientFirearmGet(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        $deploy = Deploy::where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['requestid', null],
        ])->first();

        $issuedfirearm = IssuedFirearm::with('firearm.item')->whereHas('issueditem', function($query) use ($request, $deploy) {
            $query->where([
                ['deploymentsiteid', $request->inputDeploymentSiteID],
                ['deployid', $deploy->deployid],
            ]);
        })->get();

        return Response::json($issuedfirearm);
    }



}
