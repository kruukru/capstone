<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Client;
use Amcor\Admin;
use Amcor\Contract;
use Amcor\AreaType;
use Amcor\DeploymentSite;
use Amcor\ClientQualification;
use Amcor\Account;
use Carbon\Carbon;
use Response;

class ClientController extends Controller
{
    public function getAdminClient() {
    	$clients = Client::get();

    	return view('admin.transaction.client', compact('clients'));
    }

    public function postAdminClientNew(Request $request) {
        $client = Client::where('company', $request->inputCompanyName)->get();
        if (!($client->isEmpty())) {
            return Response::json("SAME NAME", 500);
        }
        $account = Account::where('username', $request->inputUsername)->get();
        if (!($account->isEmpty())) {
            return Response::json("SAME USERNAME", 500);
        }

        $account = Account::create([
            'username' => $request->inputUsername,
            'password' => bcrypt($request->inputPassword),
            'accounttype' => 10,
        ]);

        $client = new Client;
        $client->account()->associate($account);
        $client->lastname = $request->inputLastName;
        $client->firstname = $request->inputFirstName;
        $client->middlename = $request->inputMiddleName;
        $client->position = $request->inputPosition;
        $client->contactpersonno = $request->inputContactPersonNo;
        $client->company = $request->inputCompanyName;
        $client->address = $request->inputCompanyAddress;
        $client->companycontactno = $request->inputCompanyContactNo;
        $client->email = $request->inputCompanyEmail;
        $client->status = 0;
        $client->save();

        return Response::json($client);
    }

    public function postAdminClientContractNew(Request $request) {
    	$admin = Admin::find($request->inputAdminID);
    	$client = Client::find($request->inputClientID);
    	$areatype = AreaType::find($request->inputAreaTypeID);
    	$contract = new Contract;
    	$deploymentsite = new DeploymentSite;

        $contract->admin()->associate($admin);
    	$contract->client()->associate($client);
		$contract->areatype()->associate($areatype);
        $contract->startdate = $request->inputStartdate;
        if ($request->inputLengthType == "day") {
            $contract->expiration = Carbon::createFromFormat('Y-m-d', $request->inputStartdate)->addDays($request->inputLength)->toDateString();
        } else if ($request->inputLengthType == "month") {
            $contract->expiration = Carbon::createFromFormat('Y-m-d', $request->inputStartdate)->addMonths($request->inputLength)->toDateString();
        } else if ($request->inputLengthType == "year") {
            $contract->expiration = Carbon::createFromFormat('Y-m-d', $request->inputStartdate)->addYears($request->inputLength)->toDateString();
        }
		$contract->placesigned = $request->inputPlaceHeld;
		$contract->price = $request->inputPrice;
		$contract->status = 0;
		$contract->save();

		$deploymentsite->contract()->associate($contract);
		$deploymentsite->sitename = $request->inputBuildingAreaName;
		$deploymentsite->location = $request->inputAddress;
        $deploymentsite->city = $request->inputCity;
        $deploymentsite->province = $request->inputProvince;
        $deploymentsite->latitude = $request->inputLatitude;
        $deploymentsite->longitude = $request->inputLongitude;
		$deploymentsite->status = 0;
		$deploymentsite->save();

		return Response::json($contract);
    }
}
