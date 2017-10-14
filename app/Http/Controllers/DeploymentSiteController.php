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
    //client
    public function getClientDeploymentSite() {
        if (Auth::user()->accounttype == 10) {
            $deploymentsites = DeploymentSite::whereHas('contract', function($query) {
                $query->where('clientid', Auth::user()->client->clientid);
            })->get();
        } else {
            $deploymentsites = DeploymentSite::whereHas('managersite', function($query) {
                $query->where('managerid', Auth::user()->manager->managerid);
            })->get();
        }

    	return view('client.deploymentsite', compact('deploymentsites'));
    }

    //client qualification
    public function getClientClientQualification(Request $request) {
        $clientqualification = ClientQualification::where([
            ['requestid', null],
            ['deploymentsiteid', $request->inputDeploymentSiteID]
        ])->get();

        return Response::json($clientqualification);
    }

    //client security guard
    public function postClientClientQualification(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        $qualificationcheck = QualificationCheck::where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['status', 1]
        ])->whereHas('deploy', function($query) {
            $query->where('requestid', null);
        })->get();

        $requireno = 0;
        foreach ($request->formData as $data) {
            $requireno += $data['inputRequireNo'];
        }

        if ($requireno < $qualificationcheck->count()) {
            return Response::json("INSUFFICIENT REQUIRE NO", 500);
        }

        ClientQualification::where([
            ['requestid', null],
            ['deploymentsiteid', $deploymentsite->deploymentsiteid]
        ])->forceDelete();

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
        $clientqualifications = ClientQualification::where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['requestid', null],
        ])->get();
        $requirenocheck = QualificationCheck::where([
            ['deploymentsiteid', $deploymentsite->deploymentsiteid],
            ['status', 1]
        ])->whereHas('deploy', function($query) {
            $query->where('requestid', null);
        })->get();
        $qualificationchecks = QualificationCheck::where([
            ['deploymentsiteid', $deploymentsite->deploymentsiteid],
            ['status', 0]
        ])->whereHas('deploy', function($query) {
            $query->where('requestid', null);
        })->get();

        $requireno = 0;
        foreach ($clientqualifications as $clientqualification) {
            $requireno += $clientqualification->requireno;
        }
        $requireno -= $requirenocheck->count();

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
                $applicant->lastdeployed = null;
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

            if ($data['inputStatus'] == 1) {
                $qualificationcheck->status = $data['inputStatus'];
                $qualificationcheck->save();
            } else {
                $qualificationcheck->forceDelete();
            }
        }

        if ($request->inputStatus == 0) {
            $deploymentsite->status = 3;
            $deploymentsite->save();
        } else {
            $deploymentsite->status = 1;
            $deploymentsite->save();
        }

        return Response::json($deploymentsite);
    }

    //client item
    public function getClientItem(Request $request) {
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

    public function getClientFirearm(Request $request) {
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

    public function postClientItem(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        $deploymentsite->status = 5;
        $deploymentsite->save();

        return Response::json($deploymentsite);
    }

    public function getClientView(Request $request) {
        $applicant = Applicant::whereHas('qualificationcheck', function($query) {
            $query->where('status', 1);
        })->whereHas('qualificationcheck.deploymentsite', function($query) use ($request) {
            $query->where('deploymentsiteid', $request->inputDeploymentSiteID);
        })->get();

        $item = IssuedItem::with('item.itemtype')->where('deploymentsiteid', $request->inputDeploymentSiteID)->get();

        $firearm = IssuedFirearm::with('firearm.item.itemtype')->whereHas('issueditem', function($query) use ($request) {
            $query->where('deploymentsiteid', $request->inputDeploymentSiteID);
        })->get();

        $dataArray = array(
            'applicant' => $applicant,
            'item' => $item,
            'firearm' => $firearm
        );

        return Response::json($dataArray);
    }



}
