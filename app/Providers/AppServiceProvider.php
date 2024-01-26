<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (Schema::hasTable('settings')) {
            $siteInfo = DB::table('settings')->get();
        }

        if (Schema::hasTable('admins')) {
            $adminImg = DB::table('admins')->select('image')->first();
        }
    
        view()->share(['siteInfo'=> $siteInfo,'adminImg'=> $adminImg]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
