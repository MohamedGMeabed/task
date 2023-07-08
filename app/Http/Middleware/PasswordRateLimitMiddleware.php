<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PasswordRateLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $key = 'password_attempts:' . $request->ip();

        $attempts = Cache::get($key, 0);

        if ($attempts >= 3) {
            $blockedTime = Cache::get('blocked_time:' . $request->ip());

            if ($blockedTime) {
                $secondsRemaining = $blockedTime - time();
                if ($secondsRemaining > 0) {
                    $message = 'You have exceeded the maximum login attempts. Please try again after ' . $secondsRemaining . ' seconds.';
                    return redirect()->back()->with('error', $message);
                } else {
                    // Reset the attempts and remove the blocked time
                    Cache::forget($key);
                    Cache::forget('blocked_time:' . $request->ip());
                }
            }
        }
        return $next($request);
    }
}
