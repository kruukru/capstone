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
use Amcor\ReplaceApplicant;
use Amcor\Attendance;
use Amcor\Schedule;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use Geotools;
use Response;
use Auth;
use DB;

class RequestController extends Controller
{
    //admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin 
    public function getAdminRequest() {
        $requests = Requestt::where('status', '<=', 1)->get();
        $replaceapplicants = ReplaceApplicant::get();

        return view('admin.transaction.request', compact('requests', 'replaceapplicants'));
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
        $requestt = Requestt::find($request->inputRequestID);
        $deploymentsite = DeploymentSite::find($requestt->deploymentsiteid);
        
        if ($request->inputType == 0) {
            $deploy = Deploy::where([
                ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                ['requestid', $requestt->requestid]
            ])->first();

            if ($deploy == null) {
                $deploy = new Deploy();
                $deploy->deploymentsite()->associate($deploymentsite);
                $deploy->request()->associate($requestt);
                $deploy->dateissued = Carbon::today();
                $deploy->expiration = '2020-10-10';
                $deploy->status = 0;
                $deploy->save();
            }
        } else {
            $deploy = Deploy::where([
                ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                ['requestid', $requestt->requestid]
            ])->first();

            $qualificationchecks = QualificationCheck::where([
                ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                ['deployid', $deploy->deployid],
                ['status', 0]
            ])->get();

            foreach ($qualificationchecks as $qualificationcheck) {
                $applicant = Applicant::find($qualificationcheck->applicantid);
                $applicant->status = 8;
                $applicant->save();
            }

            QualificationCheck::where([
                ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                ['deployid', $deploy->deployid],
                ['status', 0]
            ])->forceDelete();
        }

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
                $workexpout .= ",1";
            }

            //age
            $ageout = 0;
            $clientage = explode(',', $clientqualification->age);
            if ($securityguard->age == $clientage[2]) {
                $ageout = 100;
            } else if ($clientage[0] <= $securityguard->age && $securityguard->age < $clientage[2]) {
                $diff = $clientage[2] - $clientage[0];
                $ptsperpt = 100 / $diff;

                $secudiff = $securityguard->age - $clientage[0];
                $ageout += $ptsperpt * $secudiff;
            } else if ($clientage[2] < $securityguard->age && $securityguard->age <= $clientage[1]) {
                $diff = $clientage[1] - $clientage[2];
                $ptsperpt = 100 / $diff;

                $secudiff = $clientage[1] - $securityguard->age;
                $ageout += $ptsperpt * $secudiff;
            }

            //height
            $heightout = 0;
            $clientheight = explode(',', $clientqualification->height);
            if ($securityguard->height == $clientheight[2]) {
                $heightout = 100;
            } else if ($clientheight[0] <= $securityguard->height && $securityguard->height < $clientheight[2]) {
                $diff = $clientheight[2] - $clientheight[0];
                $ptsperpt = 100 / $diff;

                $secudiff = $securityguard->height - $clientheight[0];
                $heightout += $ptsperpt * $secudiff;
            } else if ($clientheight[2] < $securityguard->height && $securityguard->height <= $clientheight[1]) {
                $diff = $clientheight[1] - $clientheight[2];
                $ptsperpt = 100 / $diff;

                $secudiff = $clientheight[1] - $securityguard->height;
                $heightout += $ptsperpt * $secudiff;
            }

            //weight
            $weightout = 0;
            $clientweight = explode(',', $clientqualification->weight);
            if ($securityguard->weight == $clientweight[2]) {
                $weightout = 100;
            } else if ($clientweight[0] <= $securityguard->weight && $securityguard->weight < $clientweight[2]) {
                $diff = $clientweight[2] - $clientweight[0];
                $ptsperpt = 100 / $diff;

                $secudiff = $securityguard->weight - $clientweight[0];
                $weightout += $ptsperpt * $secudiff;
            } else if ($clientweight[2] < $securityguard->weight && $securityguard->weight <= $clientweight[1]) {
                $diff = $clientweight[1] - $clientweight[2];
                $ptsperpt = 100 / $diff;

                $secudiff = $clientweight[1] - $securityguard->weight;
                $weightout += $ptsperpt * $secudiff;
            }

            $distance = null;
            if (!($deploymentsite->longitude == null || $deploymentsite->latitude == null || $securityguard->longitude == null || $securityguard->latitude == null)) {
                $coordA = Geotools::coordinate([$deploymentsite->latitude, $deploymentsite->longitude]);
                $coordB = Geotools::coordinate([$securityguard->latitude, $securityguard->longitude]);
                $distance = Geotools::distance()->setFrom($coordA)->setTo($coordB)->in('km')->haversine();
            }

            $pool->push([
                'applicantid' => $securityguard->applicantid,
                'name' => $securityguard->lastname . ", " . $securityguard->firstname . " " . $securityguard->middlename,
                'gender' => $genderout,
                'civilstatus' => $civilstatusout,
                'attainment' => $attainmentout,
                'workexp' => $workexpout,
                'age' => $ageout,
                'weight' => $weightout,
                'height' => $heightout,
                'distance' => $distance,
                'vacant' => $securityguard->lastdeployed->diffInDays(Carbon::today()),
            ]);
        }

        $qualificationchecks = QualificationCheck::where('status', 0)
            ->whereHas('deploy', function($query) use ($clientqualification) {
                $query->where('requestid', $clientqualification->requestid);
            })->get();

        $poolsent = collect();
        foreach ($qualificationchecks as $qualificationcheck) {
            $securityguard = Applicant::find($qualificationcheck->applicantid);

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
                $workexpout .= ",1";
            }

            //age
            $ageout = 0;
            $clientage = explode(',', $clientqualification->age);
            if ($securityguard->age == $clientage[2]) {
                $ageout = 100;
            } else if ($clientage[0] <= $securityguard->age && $securityguard->age < $clientage[2]) {
                $diff = $clientage[2] - $clientage[0];
                $ptsperpt = 100 / $diff;

                $secudiff = $securityguard->age - $clientage[0];
                $ageout += $ptsperpt * $secudiff;
            } else if ($clientage[2] < $securityguard->age && $securityguard->age <= $clientage[1]) {
                $diff = $clientage[1] - $clientage[2];
                $ptsperpt = 100 / $diff;

                $secudiff = $clientage[1] - $securityguard->age;
                $ageout += $ptsperpt * $secudiff;
            }

            //height
            $heightout = 0;
            $clientheight = explode(',', $clientqualification->height);
            if ($securityguard->height == $clientheight[2]) {
                $heightout = 100;
            } else if ($clientheight[0] <= $securityguard->height && $securityguard->height < $clientheight[2]) {
                $diff = $clientheight[2] - $clientheight[0];
                $ptsperpt = 100 / $diff;

                $secudiff = $securityguard->height - $clientheight[0];
                $heightout += $ptsperpt * $secudiff;
            } else if ($clientheight[2] < $securityguard->height && $securityguard->height <= $clientheight[1]) {
                $diff = $clientheight[1] - $clientheight[2];
                $ptsperpt = 100 / $diff;

                $secudiff = $clientheight[1] - $securityguard->height;
                $heightout += $ptsperpt * $secudiff;
            }

            //weight
            $weightout = 0;
            $clientweight = explode(',', $clientqualification->weight);
            if ($securityguard->weight == $clientweight[2]) {
                $weightout = 100;
            } else if ($clientweight[0] <= $securityguard->weight && $securityguard->weight < $clientweight[2]) {
                $diff = $clientweight[2] - $clientweight[0];
                $ptsperpt = 100 / $diff;

                $secudiff = $securityguard->weight - $clientweight[0];
                $weightout += $ptsperpt * $secudiff;
            } else if ($clientweight[2] < $securityguard->weight && $securityguard->weight <= $clientweight[1]) {
                $diff = $clientweight[1] - $clientweight[2];
                $ptsperpt = 100 / $diff;

                $secudiff = $clientweight[1] - $securityguard->weight;
                $weightout += $ptsperpt * $secudiff;
            }

            $distance = null;
            if (!($deploymentsite->longitude == null || $deploymentsite->latitude == null || $securityguard->longitude == null || $securityguard->latitude == null)) {
                $coordA = Geotools::coordinate([$deploymentsite->latitude, $deploymentsite->longitude]);
                $coordB = Geotools::coordinate([$securityguard->latitude, $securityguard->longitude]);
                $distance = Geotools::distance()->setFrom($coordA)->setTo($coordB)->in('km')->haversine();
            }

            $poolsent->push([
                'applicantid' => $securityguard->applicantid,
                'name' => $securityguard->lastname . ", " . $securityguard->firstname . " " . $securityguard->middlename,
                'gender' => $genderout,
                'civilstatus' => $civilstatusout,
                'attainment' => $attainmentout,
                'workexp' => $workexpout,
                'age' => $ageout,
                'weight' => $weightout,
                'height' => $heightout,
                'distance' => $distance,
                'vacant' => $securityguard->lastdeployed->diffInDays(Carbon::today()),
            ]);
        }

        $dataArray = array(
            'pool' => $pool,
            'poolsent' => $poolsent,
        );

        return Response::json($dataArray);
    }

    //admin item
    public function getAdminItemInventory(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);

        $requestitem = RequestItem::with('item.itemtype')
            ->where('requestid', $request->inputRequestID)->get();
        $item = Item::with('itemtype')->get();

        $itemsent = null; $firearmsent = null;
        if ($requestt->deploy) {
            $itemsent = IssuedItem::with('item.itemtype')->where([
                ['deploymentsiteid', $requestt->deploymentsiteid],
                ['deployid', $requestt->deploy->deployid]
            ])->get();

            $firearmsent = Firearm::whereHas('issuedfirearm.issueditem', function($query) use ($requestt) {
                $query->where([
                    ['deploymentsiteid', $requestt->deploymentsiteid],
                    ['deployid', $requestt->deploy->deployid]
                ]);
            })->get();
        }   

        $arrayData = array(
            'requestitem' => $requestitem,
            'item' => $item,
            'itemsent' => $itemsent,
            'firearmsent' => $firearmsent
        );   

        return Response::json($arrayData);
    }

    public function getAdminFirearm(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);

        $firearm = Firearm::doesntHave('issuedfirearm')
            ->where('itemid', $request->inputItemID)->get();
        if ($requestt->deploy) {
            $firearmsave = Firearm::where('itemid', $request->inputItemID)
                ->whereHas('issuedfirearm.issueditem', function($query) use ($requestt) {
                    $query->where('deployid', $requestt->deploy->deployid);
                })->get();

            $merge = $firearm->merge($firearmsave);
            return Response::json($merge);
        }

        return Response::json($firearm);
    }

    public function postAdminItem(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);
        $deploymentsite = DeploymentSite::find($requestt->deploymentsiteid);

        if ($requestt->deploy) {
            $deploy = Deploy::find($requestt->deploy->deployid);

            $issueditems = IssuedItem::where([
                ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                ['deployid', $deploy->deployid]
            ])->get();
            foreach ($issueditems as $issueditem) {
                $item = Item::find($issueditem->itemid);
                $item->qtyavailable += $issueditem->qty;
                $item->save();
            }

            IssuedFirearm::whereHas('issueditem', function($query) use ($deploymentsite, $deploy) {
                $query->where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['deployid', $deploy->deployid]
                ]);
            })->forceDelete();
            IssuedItem::where([
                ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                ['deployid', $deploy->deployid]
            ])->forceDelete();
        } else {
            $deploy = new Deploy();
            $deploy->deploymentsite()->associate($deploymentsite);
            $deploy->request()->associate($requestt);
            $deploy->dateissued = Carbon::today();
            $deploy->expiration = '2020-10-10';
            $deploy->status = 0;
            $deploy->save();
        }

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

    //admin replace
    public function getAdminReplaceSecurityGuard(Request $request) {
        $applicants = Applicant::where('status', 8)->get();

        $pool = collect();
        foreach ($applicants as $applicant) {
            $pool->push([
                'applicantid' => $applicant->applicantid,
                'name' => $applicant->firstname . " " . $applicant->middlename . " " . $applicant->lastname,
                'vacant' => $applicant->lastdeployed->diffInDays(Carbon::today())
            ]);
        }

        return Response::json($pool);
    }

    public function postAdminReplace(Request $request) {
        $applicant = Applicant::find($request->inputApplicantID);
        $replaceapplicant = ReplaceApplicant::find($request->inputReplaceApplicantID);
        $qualificationcheck = QualificationCheck::find($replaceapplicant->qualificationcheckid);

        Schedule::where('applicantid', $qualificationcheck->applicantid)->forceDelete();
        $attendances = Attendance::where('applicantid', $qualificationcheck->applicantid)->get();
        foreach ($attendances as $attendance) {
            $attendance->status += 3;
            $attendance->save();
        }

        $applicant->status = 10;
        $applicant->lastdeployed = null;
        $applicant->save();
        
        $applicantold = Applicant::find($qualificationcheck->applicantid);
        $applicantold->lastdeployed = Carbon::today();
        $applicantold->status = 8;
        $applicantold->save();

        $qualificationcheck->applicant()->associate($applicant);
        $qualificationcheck->save();

        ReplaceApplicant::find($request->inputReplaceApplicantID)->forceDelete();

        return Response::json($applicant);
    }

    public function postAdminReplaceRemove(Request $request) {
        ReplaceApplicant::find($request->inputReplaceApplicantID)->forceDelete();

        return Response::json(400);
    }

    //client client client client client client client client client client client client client client 
    public function getClientRequest() {
        $requests = Requestt::withTrashed()->whereHas('deploymentsite.contract', function($query) {
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
    public function getClientClientQualification(Request $request) {
        $clientqualification = ClientQualification::where('requestid', $request->inputRequestID)->get();

        return Response::json($clientqualification);
    }

    public function postClientClientQualification(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);

        $applicants = Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsite) {
            $query->where([
                ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                ['status', 1]
            ]);
        })->get();

        foreach ($applicants as $applicant) {
            if (!$applicant->schedule) {
                return Response::json("INPUT ALL DATE FIRST", 500);
            }
        }

        $sunday = false; $monday = false; $tuesday = false; $wednesday = false; $thursday = false; $friday = false; $saturday = false;
        foreach ($applicants as $applicant) {
            if ($applicant->schedule->sunday == 1) {
                $sunday = true;
            }
            if ($applicant->schedule->monday == 1) {
                $monday = true;
            }
            if ($applicant->schedule->tuesday == 1) {
                $tuesday = true;
            }
            if ($applicant->schedule->wednesday == 1) {
                $wednesday = true;
            }
            if ($applicant->schedule->thursday == 1) {
                $thursday = true;
            }
            if ($applicant->schedule->friday == 1) {
                $friday = true;
            }
            if ($applicant->schedule->saturday == 1) {
                $saturday = true;
            }
        }

        $begin = new DateTime($deploymentsite->contract->startdate);
        $end = new DateTime(Carbon::today()->addDays(1));

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($period as $dt) {
            $date = Carbon::parse($dt->format('Y-m-d'));
            if ($sunday == false && $date->dayOfWeek == Carbon::SUNDAY) {

            } else if ($monday == false && $date->dayOfWeek == Carbon::MONDAY) {

            } else if ($tuesday == false && $date->dayOfWeek == Carbon::TUESDAY) {

            } else if ($wednesday == false && $date->dayOfWeek == Carbon::WEDNESDAY) {

            } else if ($thursday == false && $date->dayOfWeek == Carbon::THURSDAY) {

            } else if ($friday == false && $date->dayOfWeek == Carbon::FRIDAY) {

            } else if ($saturday == false && $date->dayOfWeek == Carbon::SATURDAY) {

            } else {
                if ($date->dayOfWeek == Carbon::SUNDAY) {
                    $dayname = 'sunday';
                } else if ($date->dayOfWeek == Carbon::MONDAY) {
                    $dayname = 'monday';
                } else if ($date->dayOfWeek == Carbon::TUESDAY) {
                    $dayname = 'tuesday';
                } else if ($date->dayOfWeek == Carbon::WEDNESDAY) {
                    $dayname = 'wednesday';
                } else if ($date->dayOfWeek == Carbon::THURSDAY) {
                    $dayname = 'thursday';
                } else if ($date->dayOfWeek == Carbon::FRIDAY) {
                    $dayname = 'friday';
                } else if ($date->dayOfWeek == Carbon::SATURDAY) {
                    $dayname = 'saturday';
                }
                $notset = Attendance::where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['date', $dt->format('Y-m-d')]
                ])->get();
                $applicantno = count(Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsite) {
                    $query->where([
                        ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                        ['status', 1]
                    ]);
                })->whereHas('schedule', function($query) use ($dayname, $date) {
                    $query->where($dayname, 1);
                })->get());
                $attendanceno = count(Attendance::where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['date', $dt->format('Y-m-d')],
                    ['timein', '!=', null],
                    ['timeout', '!=', null],
                    ['status', '!=', 2],
                    ['status', '>=', 0],
                    ['status', '<=', 1],
                ])->get()) + count(Attendance::where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['date', $dt->format('Y-m-d')],
                    ['status', 2],
                    ['status', '>=', 0],
                    ['status', '<=', 2],
                ])->get());

                if ($notset->isEmpty()) {
                    $applicantcheck = Applicant::whereDate('updated_at', '<=', $date)
                        ->whereHas('qualificationcheck', function($query) use ($deploymentsite) {
                            $query->where([
                                ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                                ['status', 1]
                            ]);
                        })->whereHas('schedule', function($query) use ($dayname, $date) {
                            $query->where($dayname, 1)
                                ->whereDate('updated_at', '<=', $date);
                        })->whereDoesntHave('attendance', function($query) use ($date) {
                            $query->where('date', $date->format('Y-m-d'));
                        })->get();

                    if (!$applicantcheck->isEmpty()) {
                        return Response::json("COMPLETE ATTENDANCE FIRST", 500);
                    }
                } else if ($applicantno == $attendanceno) {
                    
                } else {
                    $applicants = Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsite) {
                        $query->where([
                            ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                            ['status', 1]
                        ]);
                    })->get();

                    $checkdate = false;
                    foreach ($applicants as $applicant) {
                        if (new DateTime($applicant->schedule->updated_at) >= new DateTime($date)) {
                            $checkdate = true;
                        }
                    }

                    if ($checkdate) {

                    } else {
                        return Response::json("COMPLETE ATTENDANCE FIRST", 500);
                    }
                }
            }
        }

        if ($request->inputRequestID == null) {
            $requestt = new Requestt;
            $requestt->deploymentsite()->associate($deploymentsite);
            $requestt->account()->associate(Auth::user());
            $requestt->type = "PERSONNEL";
            $requestt->datecreated = Carbon::today();
            $requestt->status = 0;
            $requestt->save();
        } else {
            $requestt = Requestt::with('deploymentsite')->find($request->inputRequestID);

            if ($requestt->deploy) {
                $qualificationcheck = QualificationCheck::where([
                    ['deployid', $requestt->deploy->deployid],
                    ['status', 1]
                ])->get();

                $requireno = 0;
                foreach ($request->formData as $data) {
                    $requireno += $data['inputRequireNo'];
                }

                if ($requireno < $qualificationcheck->count()) {
                    return Response::json("INSUFFICIENT REQUIRE NO", 500);
                }
            }

            ClientQualification::where([
                ['requestid', $requestt->requestid],
                ['deploymentsiteid', $deploymentsite->deploymentsiteid]
            ])->forceDelete();
        }

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

            if ($data['inputStatus'] == 1) {
                $qualificationcheck->status = $data['inputStatus'];
                $qualificationcheck->save();
            } else {
                $qualificationcheck->forceDelete();
            }
        }

        if ($request->inputStatus == 0){
            $requestt->status = 2;
            $requestt->save();
        } else {
            $requestt->status = 0;
            $requestt->save();
        }

        return Response::json($requestt);
    }

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
        $requirenocheck = QualificationCheck::where([
            ['deployid', $deploy->deployid],
            ['status', 1]
        ])->get();
        $qualificationchecks = QualificationCheck::where([
            ['deployid', $deploy->deployid],
            ['status', 0]
        ])->get();

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
            'pool' => $pool
        );

        return Response::json($dataArray);
    }

    //client item
    public function getClientInventory(Request $request) {
    	$item = Item::with('itemtype')->where('qtyavailable', '!=', 0)->get();
        $itemsent = RequestItem::with('item.itemtype')->where('requestid', $request->inputRequestID)->get();

        $dataArray = array(
            'item' => $item,
            'itemsent' => $itemsent
        );

    	return Response::json($dataArray);
    }

    public function postClientInventory(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);

        if ($request->inputRequestID == null) {
            $requestt = new Requestt;
            $requestt->deploymentsite()->associate($deploymentsite);
            $requestt->account()->associate(Auth::user());
            $requestt->type = "ITEM";
            $requestt->datecreated = Carbon::today();
            $requestt->status = 0;
            $requestt->save();
        } else {
            $requestt = Requestt::find($request->inputRequestID);

            RequestItem::where('requestid', $requestt->requestid)->forceDelete();
        }

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
