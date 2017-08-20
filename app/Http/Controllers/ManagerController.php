<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Manager;
use Amcor\Account;
use Amcor\Client;
use Auth;
use Response;

class ManagerController extends Controller
{
    public function getClientManager() {
    	$managers = Manager::where('clientid', Auth::user()->client->clientid)->get();

    	return view('client.manager', compact('managers'));
    }

    public function postClientManagerNew(Request $request) {
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

    public function postClientManagerUpdate(Request $request) {
        $requirement = Requirement::withTrashed()
            ->where([
                ['name', $request->inputRequirement],
                ['requirementid', '!=', $request->inputRequirementID],
            ])->first();

        if ($requirement === null) {
            $requirement = Requirement::find($request->inputRequirementID);
            $requirement->name = $request->inputRequirement;
            $requirement->description = $request->inputRequirementDescription;
            $requirement->save();
        } else {
            if ($requirement->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($requirement);
    }

    public function postClientManagerRemove(Request $request) {
        $requirement = Requirement::find($request->inputRequirementID);
        $requirement->delete();

        return Response::json($requirement);
    }
}
