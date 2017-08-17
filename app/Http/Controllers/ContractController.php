<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\RateType;
use Amcor\Contract;
use Amcor\DeploymentSite;
use Amcor\Client;
use Amcor\Admin;
use Carbon\Carbon;
use Response;

class ContractController extends Controller
{
	public function getAdminContract() {
		$contracts = Contract::get();

		return view('admin.transaction.contract', compact('contracts'));
	}
}
