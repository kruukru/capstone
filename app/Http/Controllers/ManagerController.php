<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Manager;
use Amcor\Account;
use Amcor\Client;
use Amcor\DeploymentSite;
use Amcor\ManagerSite;
use Auth;
use Response;

class ManagerController extends Controller
{
    public function getClientManager() {
    	$managers = Manager::where('clientid', Auth::user()->client->clientid)->get();

    	return view('client.manager', compact('managers'));
    }

    public function postClientNew(Request $request) {
    	$account = Account::where('username', $request->inputUsername)->get();
        if (!($account->isEmpty())) {
            return Response::json("SAME USERNAME", 500);
        }

        $account = Account::create([
            'username' => $request->inputUsername,
            'password' => bcrypt($request->inputPassword),
            'accounttype' => 11,
        ]);

        $client = Client::find(Auth::user()->client->clientid);
        $manager = new Manager;
        $manager->client()->associate($client);
        $manager->account()->associate($account);
        $manager->lastname = $request->inputLastname;
        $manager->firstname = $request->inputFirstname;
        $manager->middlename = $request->inputMiddlename;
        $manager->save();

        return Response::json($manager);
    }

    public function postClientUpdate(Request $request) {
        $manager = Manager::with('Account')->find($request->inputManagerID);
        $manager->lastname = $request->inputLastname;
        $manager->firstname = $request->inputFirstname;
        $manager->middlename = $request->inputMiddlename;
        $manager->save();

        return Response::json($manager);
    }

    public function postClientUpdateAccount(Request $request) {
        $account = Account::where('username', $request->inputUsername)->get();
        if (!($account->isEmpty())) {
            return Response::json("SAME USERNAME", 500);
        }

        $manager = Manager::find($request->inputManagerID);
        $manager->account->username = $request->inputUsername;
        $manager->account->password = bcrypt($request->inputPassword);
        $manager->account->save();

        return Response::json($manager);
    }

    public function postClientRemove(Request $request) {
        $manager = Manager::find($request->inputManagerID);

        if (!$manager->account->replaceapplicant->isEmpty() || !$manager->account->request->isEmpty() || !$manager->account->report->isEmpty()) {
            return Response::json("CANNOT REMOVE", 500);
        } 

        $manager->managersite()->forceDelete();
        $manager->forceDelete();
        $manager->account()->forceDelete();

        return Response::json($manager);
    }

    public function getClientDeploymentSite(Request $request) {
        $deploymentsite = DeploymentSite::whereHas('contract', function($query) {
            $query->where([
                ['clientid', Auth::user()->client->clientid],
                ['status', 0]
            ]);
        })->whereDoesntHave('managersite', function($query) use ($request) {
            $query->where('managerid', $request->inputManagerID);
        })->get();

        return Response::json($deploymentsite);
    }

    public function getClientAssignDeploymentSite(Request $request) {
        $deploymentsite = DeploymentSite::whereHas('contract', function($query) {
            $query->where([
                ['clientid', Auth::user()->client->clientid],
                ['status', 0]
            ]);
        })->whereHas('managersite', function($query) use ($request) {
            $query->where('managerid', $request->inputManagerID);
        })->get();

        return Response::json($deploymentsite);
    }

    public function postClientDeploymentSite(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        $manager = Manager::find($request->inputManagerID);

        $managersite = new ManagerSite;
        $managersite->manager()->associate($manager);
        $managersite->deploymentsite()->associate($deploymentsite);
        $managersite->save();

        return Response::json($deploymentsite);
    }

    public function postClientAssignDeploymentSite(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        ManagerSite::where([
                ['managerid', $request->inputManagerID],
                ['deploymentsiteid', $request->inputDeploymentSiteID],
            ])->forceDelete();

        return Response::json($deploymentsite);
    }
}
