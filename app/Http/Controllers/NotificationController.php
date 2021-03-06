<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Applicant;
use Amcor\Contract;
use Amcor\Attendance;
use Carbon\Carbon;
use Auth;

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
                'topic' => "HR - POOLING",
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
                // $notifs->push([
                //     'topic' => "EXECUTIVE - CONTRACT",
                //     'description' => $contract->deploymentsite->sitename . " has expired",
                //     'priority' => $priority,
                // ]);
            } else {
                $notifs->push([
                    'topic' => "EXECUTIVE - CONTRACT",
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
                    'topic' => "HR - SECURITY GUARD LICENSE",
                    'description' => $applicant->firstname . " " . $applicant->lastname . " license has expired",
                    'priority' => $priority,
                ]);
            } else {
                $notifs->push([
                    'topic' => "HR - SECURITY GUARD LICENSE",
                    'description' => $description,
                    'priority' => $priority,
                ]);
            }
        }

        //absent
        $attendances = Attendance::where('status', 2)
            ->whereDoesntHave('relieverabsent')
            ->whereDate('date', Carbon::today())->get();
        foreach ($attendances as $attendance) {
            $notifs->push([
                'topic' => "OPERATION - SECURITY GUARD ABSENT",
                'description' => $attendance->applicant->firstname . " " . $attendance->applicant->middlename . " " . $attendance->applicant->lastname . 
                    " is absent today at " . $attendance->applicant->qualificationcheck->deploymentsite->sitename . ", " .
                    $attendance->applicant->qualificationcheck->deploymentsite->location,
                'priority' => 1
            ]);
        }

    	return view('admin.notification', compact('notifs'));
    }

    public function getClientNotification() {
        $notifs = collect();

        //contract expiration
        $contracts = Contract::where([
            ['expiration', '<=', Carbon::today()->addDays(60)],
            ['clientid', Auth::user()->client->clientid]
        ])->get();

        foreach ($contracts as $contract) {
            $description = $contract->deploymentsite->sitename . " will expire in " .
                $contract->expiration->diffInDays(Carbon::today()) . " day(s)";

            $priority = 2;
            if (Carbon::today()->diffInDays($contract->expiration, false) <= 30) {
                $priority = 1;
            }

            if (Carbon::today()->diffInDays($contract->expiration, false) <= 0) {
                // $notifs->push([
                //     'topic' => "EXECUTIVE - CONTRACT",
                //     'description' => $contract->deploymentsite->sitename . " has expired",
                //     'priority' => $priority,
                // ]);
            } else {
                $notifs->push([
                    'topic' => "CONTRACT",
                    'description' => $description,
                    'priority' => $priority,
                ]);
            }
        }

        return view('client.notification', compact('notifs'));
    }
}
