<?php

namespace App\Providers;

use App\Models\Permissions;
use App\Models\Sheets;
use App\Policies\SheetPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //policies
        Gate::policy(Sheets::class, SheetPolicy::class);

        //gates
        Gate::define('view-dashboard', function(){
            $user = Auth::user();
            $page_id = 1;//dashbaord page ID

            return $user->role->hasPermission($user, $page_id, "view");
        });

        Gate::define('view-codes', function(){
            $user = Auth::user();
            $page_id = 2; //Code page id

            return $user->role->hasPermission($user, $page_id, "view");
        });

        Gate::define('view-codeUpload', function(){
            $user = Auth::user();
            $page_id = 3; //Code upload page id

            return $user->role->hasPermission($user, $page_id, "view");
        });

        Gate::define('view-codeReset', function(){
            $user = Auth::user();
            $page_id = 4; //Code reset id

            return $user->role->hasPermission($user, $page_id, "view");
        });

        //camps
        Gate::define('view-camps', function(){
            $user = Auth::user();
            $page_id = 5; // camp page id

            return $user->role->hasPermission($user, $page_id, "view");
        });

        //sheets
        Gate::define('view-sheets', function(){
            $user = Auth::user();
            $page_id = 6; //sheets page id

            return $user->role->hasPermission($user, $page_id, "view");
        });

        //control
        Gate::define('view-control', function(){
            $user = Auth::user();
            $page_id = 7; //control page id

            return $user->role->hasPermission($user, $page_id, "view");
        });

        //report
        Gate::define('view-reports', function(){
            $user = Auth::user();
            $role_id = $user->role_id;
            $page_id = 8; //reports page id

            return $user->role->hasPermission($user, $page_id, "view");
        });

        //profile
        Gate::define('view-profile', function(){
            $user = Auth::user();
            $role_id = $user->role_id;
            $page_id = 9; //profile page id

            return $user->role->hasPermission($user, $page_id, "view");
        });

        //use paginator
        Paginator::useBootstrap();
    }
}
