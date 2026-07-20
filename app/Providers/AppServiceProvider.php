<?php

namespace App\Providers;

use App\Models\Permissions;
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
        //gates
        Gate::define('view-dashboard', function(){
            $user = Auth::user();
            $role_id = $user->role_id;
            $page_id = 1;

            return Permissions::where('role_id', $role_id)
                ->where('page_id', $page_id)
                ->where('can_view', 1)
                ->exists();
        });

        //use paginator
        Paginator::useBootstrap();
    }
}
