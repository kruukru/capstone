<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Contract;
use Amcor\DeploymentSite;
use Amcor\Client;
use Amcor\Admin;
use Amcor\IssuedItem;
use Amcor\IssuedFirearm;
use Amcor\Item;
use Amcor\QualificationCheck;
use Amcor\Applicant;
use Carbon\Carbon;
use Response;

class ContractController extends Controller
{
	public function getAdminContract() {
		$contracts = Contract::get();

		return view('admin.transaction.contract', compact('contracts'));
	}

	public function postAdminContractExtend(Request $request) {
		$contract = Contract::find($request->inputContractID);

		if ($request->inputLengthType == "day") {
            $contract->expiration = $contract->expiration->addDays($request->inputLength)->toDateString();
        } else if ($request->inputLengthType == "month") {
            $contract->expiration = $contract->expiration->addMonths($request->inputLength)->toDateString();
        } else if ($request->inputLengthType == "year") {
            $contract->expiration = $contract->expiration->addYears($request->inputLength)->toDateString();
        }
        $contract->save();

        return Response::json($contract);
	}

	public function postAdminContractTerminate(Request $request) {
		$contract = Contract::find($request->inputContractID);

		$issueditems = IssuedItem::where('deploymentsiteid', $contract->deploymentsite->deploymentsiteid)->get();
		foreach ($issueditems as $issueditem) {
			IssuedFirearm::where('issueditemid', $issueditem->issueditemid)->forceDelete();
			$item = Item::find($issueditem->itemid);
			$item->qty += $issueditem->qty;
			$item->qtyavailable += $issueditem->qty;
			$item->save();
		}

		$qualificationchecks = QualificationCheck::where('deploymentsiteid', $contract->deploymentsite->deploymentsiteid)->get();
		foreach ($qualificationchecks as $qualificationcheck) {
			$applicant = Applicant::find($qualificationcheck->applicantid);
			$applicant->lastdeployed = Carbon::today();
			$applicant->status = 8;
			$applicant->save();

			Schedule::where('applicantid', $applicant->applicantid)->forceDelete();
		}
		QualificationCheck::where('deploymentsiteid', $contract->deploymentsite->deploymentsiteid)->forceDelete();

		$contract->status = 2;
		$contract->save();

		$clientstatus = Contract::where([
			['clientid', $contract->clientid],
			['status', 0]
		])->get();

		if ($clientstatus->isEmpty()) {
			$client = Client::find($contract->clientid);
			$client->status = 0;
			$client->save();
		}

		return Response::json($contract);
	}
}
