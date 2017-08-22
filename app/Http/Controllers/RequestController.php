<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\DeploymentSite;
use Amcor\Item;
use Amcor\Requestt;
use Response;
use Auth;
use DB;

class RequestController extends Controller
{
    public function getClientRequest() {
        $requests = Requestt::whereHas('deploymentsite.contract', function($query) {
            $query->where('clientid', Auth::user()->client->clientid);
        })->get();

    	return view('client.request', compact('requests'));
    }

    public function getClientDeploymentSite() {
    	$deploymentsite = DeploymentSite::where('status', 4)->whereHas('contract', function($query) {
    		$query->where('clientid', Auth::user()->client->clientid);
    	})->get();

    	return Response::json($deploymentsite);
    }

    public function getClientItem() {
    	$item = Item::with('ItemType')->where('qtyavailable', '!=', 0)->get();

    	return Response::json($item);
    }
}
