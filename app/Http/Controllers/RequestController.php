<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\DeploymentSite;
use Amcor\Item;
use Response;
use Auth;

class RequestController extends Controller
{
    public function getClientRequest() {
    	return view('client.request');
    }

    public function getClientDeploymentSite() {
    	$deploymentsite = DeploymentSite::where('status', 3)->whereHas('contract', function($query) {
    		$query->where('clientid', Auth::user()->client->clientid);
    	})->get();

    	return Response::json($deploymentsite);
    }

    public function getClientItem() {
    	$item = Item::with('ItemType')->where('qtyavailable', '!=', 0)->get();

    	return Response::json($item);
    }
}
