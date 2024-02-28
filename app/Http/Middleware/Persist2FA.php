<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Persist2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        /**
         * @var User $user
         *
         * */
        if (null === $user->two_factor_recovery_codes)
        {
            return redirect()->route('profile.show')->with('danger', 'Uff! Activar el 2FA para realizar para continuar!');
        }

        return $next($request);
    }
}
