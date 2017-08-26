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
use Carbon\Carbon;
use Response;
use Auth;
use DB;

class RequestController extends Controller
{
    //admin
    public function getAdminRequest() {
        $requests = Requestt::get();

        return view('admin.transaction.request', compact('requests'));
    }

    public function getAdminFirearm(Request $request) {
        $firearm = Firearm::doesntHave('issuedfirearm')
            ->where('itemid', $request->inputItemID)->get();

        return Response::json($firearm);
    }

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

    public function postAdminDecline(Request $request) {
        $requestt = Requestt::find($request->inputRequestID);
        $requestt->requestitem()->delete();
        $requestt->delete();

        return Response::json($requestt);
    }

    public function postAdminRequestItem(Request $request) {
        $requestt = Requestt::with('deploymentsite')->with('account.client')
            ->with('account.manager')->find($request->inputRequestID);
        // $deploymentsite = DeploymentSite::find($requestt->deploymentsiteid);
        // $deploy = new Deploy();
        // $deploy->deploymentsite()->associate($deploymentsite);
        // $deploy->dateissued = Carbon::today();
        // $deploy->expiration = '2020-10-10';
        // $deploy->status = 0;
        // $deploy->save();

        // foreach ($request->inputItemList as $data) {
        //     $item = Item::find($data['inputItemID']);
        //     $item->qtyavailable -= $data['inputQty'];
        //     $item->save();

        //     $issueditem = new IssuedItem;
        //     $issueditem->deploymentsite()->associate($deploymentsite);
        //     $issueditem->deploy()->associate($deploy);
        //     $issueditem->item()->associate($item);
        //     $issueditem->qty = $data['inputQty'];
        //     $issueditem->save();

        //     foreach ($request->inputFirearmList as $data) {
        //         if ($issueditem->itemid == $data['inputItemID']) {
        //             $firearm = Firearm::find($data['inputFirearmID']);
        //             $issuedfirearm = new IssuedFirearm;
        //             $issuedfirearm->issueditem()->associate($issueditem);
        //             $issuedfirearm->firearm()->associate($firearm);
        //             $issuedfirearm->save();
        //         }
        //     }
        // }

        // $requestt->status = 1;
        // $requestt->save();

        return Response::json($requestt);
    }

    //client
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
