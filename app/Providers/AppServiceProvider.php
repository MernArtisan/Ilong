<?php

namespace App\Providers;

use App\Models\Inquiry;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{ 
    public function register(): void
    {
        
    }
 
    public function boot(): void
    { 
        $pendingUsers = User::where('login_status', 'pending')->has('professionalProfile')->get();
        $pendingCount = $pendingUsers->count(); // Count of pending users
        $contactNotification = Inquiry::where('seen', 0)
        ->get();
        view()->share('pendingCount', $pendingCount);
        view()->share('pendingUsers', $pendingUsers);
        view()->share('contactNotification', $contactNotification);


        View::composer('*', function ($view) {
            $authId = auth()->user()->id ?? null;

            if ($authId) { 
                $appRequestCount = User::where('id', '!=', $authId)
                    ->where('role', 'professional')
                    ->where('login_status', 'pending')
                    ->has('professionalProfile')
                    ->count();
                $view->with('appRequestCount', $appRequestCount);
            }
        });
    }
}
