<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\ItemType;
use Amcor\Item;
use Amcor\Firearm;
use Response;

class InventoryController extends Controller
{
    public function getAdminInventory() {
    	$items = Item::get();
        $firearms = Firearm::get();

        return view('admin.transaction.inventory', compact('items', 'firearms'));
    }

    public function postAdminItemAdd(Request $request) {
    	$item = Item::with('itemtype')->find($request->inputItemID);
    	$item->qty += $request->inputQuantity;
    	$item->qtyavailable += $request->inputQuantity;
    	$item->save();

    	return Response::json($item);
    }

    public function postAdminItemRemove(Request $request) {
        $item = Item::find($request->inputItemID);
        $item->qty -= $request->inputQuantity;
        $item->qtyavailable -= $request->inputQuantity;
        $item->save();

        return Response::json($item);
    }

    public function postAdminFirearmAdd(Request $request) {
        $item = Item::with('itemtype')->find($request->inputItemID);

        $count = 0;
        foreach ($request->formData as $data) {
            $firearm = new Firearm;
            $firearm->item()->associate($item);
            $firearm->license = $data['inputLicense'];
            $firearm->expiration = $data['inputExpiration'];
            $firearm->save();
            $count++;
        }

        $item->qty += $count;
        $item->qtyavailable += $count;
        $item->save();

        return Response::json($item);
    }

    public function postAdminFirearmUpdate(Request $request) {
        $firearm = Firearm::find($request->inputFirearmID);
        $firearm->expiration = $request->inputExpiration;
        $firearm->save();

        return Response::json($firearm);
    }

    public function postAdminFirearmRemove(Request $request) {
        $firearm = Firearm::find($request->inputFirearmID);
        $item = Item::find($firearm->itemid);

        $item->qty -= 1;
        $item->qtyavailable -= 1;
        $item->save();
        $firearm->forceDelete();

        return Response::json(400);
    }
}
