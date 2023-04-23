<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\DiscardReport;
use App\Models\Complaint;
use App\Models\Notification;
use App\Models\Offer;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
         view()->composer('layouts.navbars.sidebar', function ($view) {
            $view->with('discardCount',
                DiscardReport::whereIn('status', ['GENERATED','UNDERPROCESS'])->count());
            $view->with('complaintCount',Complaint::whereIn('reason', ['GENERATED','UNDERPROCESS'])->count());
        });
        view()->composer('dashboard', function ($view) {
            $view->with('discardCount',
                DiscardReport::whereIn('status', ['GENERATED','UNDERPROCESS'])->count());
            $view->with('complaintCount',Complaint::whereIn('reason', ['GENERATED','UNDERPROCESS'])->count());
            $view->with('notification',Notification::where('created_dt','=',date('Y-m-d'))->count());
            $view->with('offers',Offer::where('from_dt','>=',date('Y-m-d'))
                                      ->where('to_dt','<=',date('Y-m-d'))->count());
            $view->with('discardList',
                DiscardReport::orderBy('report_dt','desc')->limit(5)->get());
            $view->with('complaintList',Complaint::orderBy('id','desc')->limit(5)->get());
        });

    }
}
