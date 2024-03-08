<?php

namespace App\Providers;

use App\Models\Organizer;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app', 'components.dashboard-layout'],  function ($view) {
            if ($user = Auth::user()) {
                if ($user->hasRole('organizer') && $notifications = Notification::where('organizer_id', Organizer::where('user_id', $user->id)->first()->id)->get()) {
                    $view->with('notifications', $notifications);
                }
            }
        });
    }
}
