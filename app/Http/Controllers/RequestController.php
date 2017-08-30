<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\DeploymentSite;
use Amcor\Deploy;
use Amcor\Item;
use Amcor\IssuedItem;
use Amcor\RequestItem;
use Amcor\Firearm;
use Amcor\IssuedFirearm;
use Amcor\Requestt;
use Amcor\ClientQualification;
use Amcor\QualificationCheck;
use Amcor\Applicant;
use Amcor\EducationBackground;
use Carbon\Carbon;
use Geotools;
use Response;
use Auth;
use DB;

class RequestController extends Controller
{
    //admin
    public function getAdminRequest() {
        $requests = Requestt::where('status', '<=', 1)->get();

        return view('admin.transaction.request', compact('requests'));
    }

    public function postAdminDecline(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);
        $requestt->clientqualification()->delete();
        $requestt->requestitem()->delete();
        $requestt->delete();

        return Response::json($requestt);
    }

    //admin security guard
    public function getAdminClientQualification(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);

        $clientqualification = ClientQualification::where([
            ['deploymentsiteid', $requestt->deploymentsiteid],
            ['requestid', $requestt->requestid],
        ])->get();

        return Response::json($clientqualification);
    }

    public function postAdminClientQualification(Request $request) {
        $requestt = Requestt::with('deploymentsite')->with('account.client')
            ->with('account.manager')->find($request->inputRequestID);
        $deploymentsite = DeploymentSite::find($requestt->deploymentsiteid);
        
        $deploy = new Deploy();
        $deploy->deploymentsite()->associate($deploymentsite);
        $deploy->request()->associate($requestt);
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

        $requestt->status = 1;
        $requestt->save();

        return Response::json($requestt);
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
                'vacant' => $securityguard->lastdeployed->diffInDays(Carbon::today()),
            ]);
        }

        return Response::json($pool);
    }

    //admin item
    public function getAdminItemInventory(Request $request) {
        $requestitem = RequestItem::with('item.itemtype')
            ->where('requestid', $request->inputRequestID)->get();
        $item = Item::with('itemtype')->get();

        $arrayData = array(
            'requestitem' => $requestitem,
            'item' => $item,
        );   

        return Response::json($arrayData);
    }

    public function getAdminFirearm(Request $request) {
        $firearm = Firearm::doesntHave('issuedfirearm')
            ->where('itemid', $request->inputItemID)->get();

        return Response::json($firearm);
    }

    public function postAdminItem(Request $request) {
        $requestt = Requestt::with('deploymentsite')->with('account.client')
            ->with('account.manager')->find($request->inputRequestID);
        $deploymentsite = DeploymentSite::find($requestt->deploymentsiteid);

        $deploy = new Deploy();
        $deploy->deploymentsite()->associate($deploymentsite);
        $deploy->request()->associate($requestt);
        $deploy->dateissued = Carbon::today();
        $deploy->expiration = '2020-10-10';
        $deploy->status = 0;
        $deploy->save();

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

        $requestt->status = 1;
        $requestt->save();

        return Response::json($requestt);
    }

    //client
    public function getClientRequest() {
        $requests = Requestt::withTrashed()->where([
            ['status', '>=', 0],
            ['status', '<=', 1],
        ])->whereHas('deploymentsite.contract', function($query) {
            $query->where('clientid', Auth::user()->client->clientid);
        })->get();

    	return view('client.request', compact('requests'));
    }

    public function getClientDeploymentSite() {
    	$deploymentsite = DeploymentSite::where('status', 5)->whereHas('contract', function($query) {
    		$query->where('clientid', Auth::user()->client->clientid);
    	})->get();

    	return Response::json($deploymentsite);
    }

    public function postClientRemove(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);
        $requestt->clientqualification()->forceDelete();
        $requestt->requestitem()->forceDelete();
        $requestt->forceDelete();

        return Response::json($requestt);
    }

    //client security guard
    public function getClientSecurityGuardList(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);
        $deploymentsite = DeploymentSite::find($requestt->deploymentsiteid);

        $deploy = Deploy::where([
            ['deploymentsiteid', $requestt->deploymentsiteid],
            ['requestid', $requestt->requestid],
        ])->first();
        $clientqualifications = ClientQualification::where([
            ['deploymentsiteid', $requestt->deploymentsiteid],
            ['requestid', $requestt->requestid],
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
        $requestt = Requestt::find($request->inputRequestID);
        $deploy = Deploy::where([
            ['deploymentsiteid', $requestt->deploymentsiteid],
            ['requestid', $requestt->requestid],
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

            $qualificationcheck->status = $data['inputStatus'];
            $qualificationcheck->save();
        }

        $requestt->status = 2;
        $requestt->save();

        return Response::json($requestt);
    }

    public function postClientClientQualification(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);

        $requestt = new Requestt;
        $requestt->deploymentsite()->associate($deploymentsite);
        $requestt->account()->associate(Auth::user());
        $requestt->type = "PERSONNEL";
        $requestt->datecreated = Carbon::today();
        $requestt->status = 0;
        $requestt->save();

        foreach($request->formData as $data) {
            $clientqualification = new ClientQualification;
            $clientqualification->deploymentsite()->associate($deploymentsite);
            $clientqualification->request()->associate($requestt);
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

        return Response::json($requestt);
    }

    //client item
    public function getClientInventory() {
    	$item = Item::with('ItemType')->where('qtyavailable', '!=', 0)->get();

    	return Response::json($item);
    }

    public function postClientInventory(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);

        $requestt = new Requestt;
        $requestt->deploymentsite()->associate($deploymentsite);
        $requestt->account()->associate(Auth::user());
        $requestt->type = "ITEM";
        $requestt->datecreated = Carbon::today();
        $requestt->status = 0;
        $requestt->save();

        foreach ($request->formData as $data) {
            $item = Item::find($data['inputItemID']);
            $requestitem = new RequestItem;
            $requestitem->request()->associate($requestt);
            $requestitem->item()->associate($item);
            $requestitem->qty = $data['inputQty'];
            $requestitem->save();
        }

        return Response::json($requestt);
    }

    public function getClientItem(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);
        $deploy = Deploy::where([
            ['deploymentsiteid', $requestt->deploymentsiteid],
            ['requestid', $requestt->requestid],
        ])->first();

        $issueditem = IssuedItem::with('item.itemtype')->where([
            ['deploymentsiteid', $requestt->deploymentsiteid],
            ['deployid', $deploy->deployid],
        ])->get();

        return Response::json($issueditem);
    }

    public function getClientFirearm(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);
        $deploy = Deploy::where([
            ['deploymentsiteid', $requestt->deploymentsiteid],
            ['requestid', $requestt->requestid],
        ])->first();

        $issuedfirearm = IssuedFirearm::with('firearm.item')->whereHas('issueditem', function($query) use ($requestt, $deploy) {
            $query->where([
                ['deploymentsiteid', $requestt->deploymentsiteid],
                ['deployid', $deploy->deployid],
            ]);
        })->get();

        return Response::json($issuedfirearm);
    }

    public function postClientItem(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);
        $requestt->status = 2;
        $requestt->save();

        return Response::json($requestt);
    }



}
