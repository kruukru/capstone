<?php

namespace Amcor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Amcor\Applicant;
use Amcor\Contract;
use Amcor\Company;
use Carbon\Carbon;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // //notification admin
        // try {
        //     $notification = collect();

        //     //security guard pooling vacant
        //     $countone = 0; $counttwo = 0;
        //     $applicants = Applicant::where([
        //         ['status', 8],
        //         ['lastdeployed', '<=', Carbon::today()->addDays(-30)]
        //     ])->get();
        //     foreach ($applicants as $applicant) {
        //         if ($applicant->lastdeployed->diffInDays(Carbon::today()) >= 60) {
        //             $countone++;
        //         } else {
        //             $counttwo++;
        //         }
        //     }
        //     if ($countone != 0) {
        //         $notification->push([
        //             'description' => $countone . " SG(s) need to deploy this month",
        //             'priority' => 1,
        //         ]);
        //     }
        //     if ($counttwo != 0) {
        //         $notification->push([
        //             'description' => $counttwo . " SG(s) need to deploy soon",
        //             'priority' => 2,
        //         ]);
        //     }

        //     //contract expiration
        //     $countone = 0; $counttwo = 0; $countthree = 0;
        //     $contracts = Contract::where('expiration', '<=', Carbon::today()->addDays(60))->get();
        //     foreach ($contracts as $contract) {
        //         if (Carbon::today()->diffInDays($contract->expiration, false) <= 0) {
        //             $countone++;
        //         } else if (Carbon::today()->diffInDays($contract->expiration, false) <= 30) {
        //             $counttwo++;
        //         } else {
        //             $countthree++;
        //         }
        //     }
        //     // if ($countone != 0) {
        //     //     $notification->push([
        //     //         'description' => $countone . " Contract(s) has expired",
        //     //         'priority' => 1,
        //     //     ]);
        //     // }
        //     if ($counttwo != 0) {
        //         $notification->push([
        //             'description' => $counttwo . " Contract(s) will expire this month",
        //             'priority' => 1,
        //         ]);
        //     }
        //     if ($countthree != 0) {
        //         $notification->push([
        //             'description' => $countthree . " Contract(s) will expire soon",
        //             'priority' => 2,
        //         ]);
        //     }

        //     //security guard license expiration
        //     $countone = 0; $counttwo = 0; $countthree = 0;
        //     $applicants = Applicant::where('licenseexpiration', '<=', Carbon::today()->addDays(60))->get();
        //     foreach ($applicants as $applicant) {
        //         if (Carbon::today()->diffInDays($applicant->licenseexpiration, false) <= 0) {
        //             $countone++;
        //         } else if (Carbon::today()->diffInDays($applicant->licenseexpiration, false) <= 30) {
        //             $counttwo++;
        //         } else {
        //             $countthree++;
        //         }
        //     }
        //     if ($countone != 0) {
        //         $notification->push([
        //             'description' => $countone . " SG(s) license has expired",
        //             'priority' => 1,
        //         ]);
        //     }
        //     if ($counttwo != 0) {
        //         $notification->push([
        //             'description' => $counttwo . " SG(s) license will expire this month",
        //             'priority' => 1,
        //         ]);
        //     }
        //     if ($countthree != 0) {
        //         $notification->push([
        //             'description' => $countthree . " SG(s) license will expire soon",
        //             'priority' => 2,
        //         ]);
        //     }

        //     $notifications = $notification->sortBy('priority');
        // } catch (\Exception $e) {}

        // //notification client
        // try {
        //     $notification = collect();

        //     //contract expiration
        //     $countone = 0; $counttwo = 0; $countthree = 0;
        //     view()->composer('*', function($view) {
        //         $contracts = Contract::where([
        //             ['expiration', '<=', Carbon::today()->addDays(60)],
        //             ['clientid', Auth::user()->client->clientid]
        //         ])->get();
        //     });

        //     foreach ($contracts as $contract) {
        //         if (Carbon::today()->diffInDays($contract->expiration, false) <= 0) {
        //             $countone++;
        //         } else if (Carbon::today()->diffInDays($contract->expiration, false) <= 30) {
        //             $counttwo++;
        //         } else {
        //             $countthree++;
        //         }
        //     }
        //     // if ($countone != 0) {
        //     //     $notification->push([
        //     //         'description' => $countone . " Contract(s) has expired",
        //     //         'priority' => 1,
        //     //     ]);
        //     // }
        //     if ($counttwo != 0) {
        //         $notification->push([
        //             'description' => $counttwo . " Contract(s) will expire this month",
        //             'priority' => 1,
        //         ]);
        //     }
        //     if ($countthree != 0) {
        //         $notification->push([
        //             'description' => $countthree . " Contract(s) will expire soon",
        //             'priority' => 2,
        //         ]);
        //     }

        //     $clientnotifications = $notification->sortBy('priority');
        // } catch (\Exception $e) {}

        // //company
        // try {
        //     $company = Company::first();
        // } catch (\Exception $e) {}

        // View::share('notifications', $notifications);
        // View::share('clientnotifications', $clientnotifications);
        // View::share('company', $company);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
