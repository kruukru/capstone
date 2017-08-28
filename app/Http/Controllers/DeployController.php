<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\DeploymentSite;
use Amcor\ClientQualification;
use Amcor\Contract;
use Amcor\Applicant;
use Amcor\EducationBackground;
use Amcor\EmploymentRecord;
use Amcor\Deploy;
use Amcor\QualificationCheck;
use Amcor\Item;
use Amcor\Firearm;
use Amcor\IssuedItem;
use Amcor\IssuedFirearm;
use Carbon\Carbon;
use Geotools;
use Response;

class DeployController extends Controller
{
    //deploy security guard
    public function getAdminDeploySecurityGuard() {
        $deploymentsites = DeploymentSite::where([
                ['status', '>=', 1],
                ['status', '<=', 2],
            ])->get();

        return view('admin.transaction.deploysecurityguard', compact('deploymentsites'));
    }

    public function getAdminClientQualification(Request $request) {
        $clientqualification = ClientQualification::where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['requestid', null],
        ])->get();

        return Response::json($clientqualification);
    }

    public function getAdminSecurityGuardPercent(Request $request) {
        $clientqualification = ClientQualification::find($request->inputClientQualificationID);
        $deploymentsite = DeploymentSite::find($clientqualification->deploymentsiteid);
        $securityguards = Applicant::where('status', 8)->get();

        $pool = collect();
        foreach ($securityguards as $securityguard) {
            $points = 0;

            //gender
            $genderout = $securityguard->gender;
            $genders = explode(',', $clientqualification->gender);
            foreach ($genders as $gender) {
                if ($gender == $securityguard->gender) {
                    $genderout .= ",1";
                    break;
                }
            }

            //secu attainment
            $attainmentout = null; $attainmentorder = 0; $check = false;
            $secuattainments = EducationBackground::where('applicantid', $securityguard->applicantid)->get();
            foreach ($secuattainments as $secuattainment) {
                if ($secuattainment->graduatetype == "College") {
                    $secuattainment->graduatetype = 3;
                } else if ($secuattainment->graduatetype == "Vocational") {
                    $secuattainment->graduatetype = 2;
                } else if ($secuattainment->graduatetype == "High School") {
                    $secuattainment->graduatetype = 1;
                } else if ($secuattainment->graduatetype == "Elementary") {
                    $secuattainment->graduatetype = 0;
                }
            }
            foreach ($secuattainments as $secuattainment) {
                if ($secuattainment->graduatetype > $attainmentorder) {
                    $attainmentorder = $secuattainment->graduatetype;
                }
            }
            if ($attainmentorder == 3) {
                $attainmentout = "College";
            } else if ($attainmentorder == 2) {
                $attainmentout = "Vocational";
            } else if ($attainmentorder == 1) {
                $attainmentout = "High School";
            } else if ($attainmentorder == 0) {
                $attainmentout = "Elementary";
            }

            //client attainment
            $clientattainment = explode(',', $clientqualification->attainment);
            $clientattainment = reset($clientattainment);
            if ($clientattainment == "College") {
                $clientattainment = 3;
            } else if ($clientattainment == "Vocational") {
                $clientattainment = 2;
            } else if ($clientattainment == "High School") {
                $clientattainment = 1;
            } else if ($clientattainment == "Elementary") {
                $clientattainment = 0;
            }
            //attainment process
            if ($attainmentorder >= $clientattainment) {
                $attainmentout .= ",1";
            }

            //civil status
            $civilstatusout = $securityguard->civilstatus;
            $civilstatuses = explode(',', $clientqualification->civilstatus);
            foreach ($civilstatuses as $civilstatus) {
                if ($civilstatus == $securityguard->civilstatus) {
                    $civilstatusout .= ",1";
                    break;
                }
            }

            //workexp
            $workexpout = $securityguard->workexp;
            if ($workexpout >= $clientqualification->workexp) {
                $points += 100;
            }

            //age
            $clientage = explode(',', $clientqualification->age);
            if ($securityguard->age == $clientage[2]) {
                $points = 100;
            } else if ($clientage[0] <= $securityguard->age && $securityguard->age < $clientage[2]) {
                $diff = $clientage[2] - $clientage[0];
                $ptsperpt = 100 / $diff;

                $secudiff = $securityguard->age - $clientage[0];
                $points += $ptsperpt * $secudiff;
            } else if ($clientage[2] < $securityguard->age && $securityguard->age <= $clientage[1]) {
                $diff = $clientage[1] - $clientage[2];
                $ptsperpt = 100 / $diff;

                $secudiff = $clientage[1] - $securityguard->age;
                $points += $ptsperpt * $secudiff;
            }

            //height
            $clientheight = explode(',', $clientqualification->height);
            if ($securityguard->height == $clientheight[2]) {
                $points = 100;
            } else if ($clientheight[0] <= $securityguard->height && $securityguard->height < $clientheight[2]) {
                $diff = $clientheight[2] - $clientheight[0];
                $ptsperpt = 100 / $diff;

                $secudiff = $securityguard->height - $clientheight[0];
                $points += $ptsperpt * $secudiff;
            } else if ($clientheight[2] < $securityguard->height && $securityguard->height <= $clientheight[1]) {
                $diff = $clientheight[1] - $clientheight[2];
                $ptsperpt = 100 / $diff;

                $secudiff = $clientheight[1] - $securityguard->height;
                $points += $ptsperpt * $secudiff;
            }

            //weight
            $clientweight = explode(',', $clientqualification->weight);
            if ($securityguard->weight == $clientweight[2]) {
                $points = 100;
            } else if ($clientweight[0] <= $securityguard->weight && $securityguard->weight < $clientweight[2]) {
                $diff = $clientweight[2] - $clientweight[0];
                $ptsperpt = 100 / $diff;

                $secudiff = $securityguard->weight - $clientweight[0];
                $points += $ptsperpt * $secudiff;
            } else if ($clientweight[2] < $securityguard->weight && $securityguard->weight <= $clientweight[1]) {
                $diff = $clientweight[1] - $clientweight[2];
                $ptsperpt = 100 / $diff;

                $secudiff = $clientweight[1] - $securityguard->weight;
                $points += $ptsperpt * $secudiff;
            }

            $distance = null;
            if (!($deploymentsite->longitude == null || $deploymentsite->latitude == null || $securityguard->longitude == null || $securityguard->latitude == null)) {
                $coordA = Geotools::coordinate([$deploymentsite->latitude, $deploymentsite->longitude]);
                $coordB = Geotools::coordinate([$securityguard->latitude, $securityguard->longitude]);
                $distance = Geotools::distance()->setFrom($coordA)->setTo($coordB)->in('km')->haversine();
            }

            $pool->push([
                'applicantid' => $securityguard->applicantid,
                'gender' => $genderout,
                'civilstatus' => $civilstatusout,
                'attainment' => $attainmentout,
                'name' => $securityguard->lastname . ", " . $securityguard->firstname . " " . $securityguard->middlename,
                'distance' => $distance,
                'points' => ($points / 400) * 100,
            ]);
        }

        return Response::json($pool);
    }

    public function postAdminDeploySecurityGuard(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        
        $deploy = new Deploy();
        $deploy->deploymentsite()->associate($deploymentsite);
        $deploy->dateissued = Carbon::today();
        $deploy->expiration = '2020-10-10';
        $deploy->status = 0;
        $deploy->save();

        foreach ($request->formData as $data) {
            $qualificationcheck = new QualificationCheck();
            $qualificationcheck->deploymentsite()->associate($deploymentsite);
            $qualificationcheck->deploy()->associate($deploy);
            $qualificationcheck->applicant()->associate(Applicant::find($data['inputApplicantID']));
            $qualificationcheck->status = 0;
            $qualificationcheck->save();

            $applicant = Applicant::find($data['inputApplicantID']);
            $applicant->status = 9;
            $applicant->save();
        }

        $deploymentsite->status = 2;
        $deploymentsite->save();

        return Response::json($deploymentsite);
    }

    

    //deploy item
    public function getAdminDeployItem() {
        $deploymentsites = DeploymentSite::where([
            ['status', '>=', 3],
            ['status', '<=', 4],
        ])->get();

        return view('admin.transaction.deployitem', compact('deploymentsites'));
    }

    public function postAdminDeployItem(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        $deploy = Deploy::where([
            ['deploymentsiteid', $deploymentsite->deploymentsiteid],
            ['requestid', null],
        ])->first();

        foreach ($request->inputItemList as $data) {
            $item = Item::find($data['inputItemID']);
            $item->qtyavailable -= $data['inputQty'];
            $item->save();

            $issueditem = new IssuedItem;
            $issueditem->deploymentsite()->associate($deploymentsite);
            $issueditem->deploy()->associate($deploy);
            $issueditem->item()->associate($item);
            $issueditem->qty = $data['inputQty'];
            $issueditem->save();

            if ($request->inputFirearmList != null) {
                foreach ($request->inputFirearmList as $data) {
                    if ($issueditem->itemid == $data['inputItemID']) {
                        $firearm = Firearm::find($data['inputFirearmID']);
                        $issuedfirearm = new IssuedFirearm;
                        $issuedfirearm->issueditem()->associate($issueditem);
                        $issuedfirearm->firearm()->associate($firearm);
                        $issuedfirearm->save();
                    }
                }
            }
        }

        $deploymentsite->status = 4;
        $deploymentsite->save();

        return Response::json($deploymentsite);
    }

    public function getAdminFirearm(Request $request) {
        $firearm = Firearm::doesntHave('issuedfirearm')
            ->where('itemid', $request->inputItemID)->get();

        return Response::json($firearm);
    }

    public function getAdminInventorySecurityGuard(Request $request) {
        $item = Item::with('ItemType')->get();
        $deploy = Deploy::where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['requestid', null],
        ])->first();
        $applicant = Applicant::whereHas('qualificationcheck', function($query) use ($deploy) {
            $query->where([
                ['deployid', $deploy->deployid],
                ['status', 1],
            ]);
        })->get();

        $arrayData = array(
            'item' => $item,
            'applicant' => $applicant,
        );        

        return Response::json($arrayData);
    }



}
