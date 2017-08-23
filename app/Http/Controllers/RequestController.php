<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\DeploymentSite;
use Amcor\RequestItem;
use Amcor\Item;
use Amcor\Requestt;
use Carbon\Carbon;
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

    public function postClientItem(Request $request) {
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

    public function postClientItemRemove(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);
        $requestt->requestitem()->forceDelete();
        $requestt->forceDelete();

        return Response::json($requestt);
    }
}
