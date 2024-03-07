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
        View::composer(['layouts.app'],  function ($view) {
            $organizer = Organizer::where('user_id', Auth::id())->get();
            if ($organizer->count() !== 0) {
                $notifications = Notification::where('organizer_id', $organizer->id)->get();
                // dd($notifications);
                $view->with('notifications', $notifications);
            }
        });
    }
}
