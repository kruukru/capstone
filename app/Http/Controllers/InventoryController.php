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

        return view('admin.transaction.inventory', compact('items'));
    }

    public function getValidateFirearm(Request $request) {
        $firearm = Firearm::where('license', $request->inputLicense)
            ->first();

        if ($firearm !== null) {
            return Response::json("SAME LICENSE", 500);
        }

        return Response::json($firearm);
    }

    public function postAdminInventoryAddItem(Request $request) {
    	$item = Item::with('ItemType')->find($request->inputItemID);
    	$item->qty += $request->inputQuantity;
    	$item->qtyavailable += $request->inputQuantity;
    	$item->save();

    	return Response::json($item);
    }

    public function postAdminInventoryAddFirearm(Request $request) {
        $item = Item::with('ItemType')->find($request->inputItemID);

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
}
