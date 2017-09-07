<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Applicant;
use Amcor\Contract;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function getAdminNotification() {
    	$notifs = collect();

        //pooling vacant
        $applicants = Applicant::where('lastdeployed', '<=', Carbon::today()->addDays(-30))->get();
        foreach ($applicants as $applicant) {
            $description = $applicant->firstname . " " . $applicant->lastname .
                " has been vacant for " . $applicant->lastdeployed->diffInDays(Carbon::today()) . " day(s)";

            $priority = 2;
            if ($applicant->lastdeployed->diffInDays(Carbon::today()) >= 60) {
                $priority = 1;
            }

            $notifs->push([
                'topic' => "POOLING",
                'description' => $description,
                'priority' => $priority,
            ]);
        }

        //contract expiration
        $contracts = Contract::where('expiration', '<=', Carbon::today()->addDays(60))->get();
        foreach ($contracts as $contract) {
            $description = $contract->deploymentsite->sitename . " will expire in " .
                $contract->expiration->diffInDays(Carbon::today()) . " day(s)";

            $priority = 2;
            if (Carbon::today()->diffInDays($contract->expiration, false) <= 30) {
                $priority = 1;
            }

            if (Carbon::today()->diffInDays($contract->expiration, false) <= 0) {
                $notifs->push([
                    'topic' => "CONTRACT",
                    'description' => $contract->deploymentsite->sitename . " has expired",
                    'priority' => $priority,
                ]);
            } else {
                $notifs->push([
                    'topic' => "CONTRACT",
                    'description' => $description,
                    'priority' => $priority,
                ]);
            }
        }

        //security guard license expiration
        $applicants = Applicant::where('licenseexpiration', '<=', Carbon::today()->addDays(60))->get();
        foreach ($applicants as $applicant) {
            $description = $applicant->firstname . " " . $applicant->lastname . " license will expire in " .
                $applicant->licenseexpiration->diffInDays(Carbon::today()) . " day(s)";

            $priority = 2;
            if (Carbon::today()->diffInDays($applicant->licenseexpiration, false) <= 30) {
                $priority = 1;
            }

            if (Carbon::today()->diffInDays($applicant->licenseexpiration, false) <= 0) {
                $notifs->push([
                    'topic' => "SECURITY GUARD LICENSE",
                    'description' => $applicant->firstname . " " . $applicant->lastname . " license has expired",
                    'priority' => $priority,
                ]);
            } else {
                $notifs->push([
                    'topic' => "SECURITY GUARD LICENSE",
                    'description' => $description,
                    'priority' => $priority,
                ]);
            }
        }

    	return view('admin.notification', compact('notifs'));
    }
}
