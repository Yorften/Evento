<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Ban;
use App\Models\Client;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientOrganizerVerification
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && ($user->hasRole('client') || $user->hasRole('organizer'))) {
            if ($user->hasRole('organizer')) {
                if (!Organizer::where('user_id', $user->id)->exists()) {
                    return redirect()->route('organizers.create');
                }
            }

            if ($user->hasRole('client')) {
                if (!Client::where('user_id', $user->id)->exists()) {
                    return redirect()->route('clients.create');
                }
            }
        }

        return $next($request);
    }
}
