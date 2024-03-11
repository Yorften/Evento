<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Organizer;
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
                if ($user->hasRole('client') && $notifications = Notification::where('client_id', Client::where('user_id', $user->id)->first()->id)->get()) {
                    $view->with('notifications', $notifications);
                }
                if ($user->hasRole('organizer') && $org_notifications = Event::where('organizer_id', Organizer::where('user_id', $user->id)->first()->id)->where('verified', true)->orWhere('verified', false)->get()) {
                    $view->with('org_notifications', $org_notifications);
                }
            }
        });
    }
}
