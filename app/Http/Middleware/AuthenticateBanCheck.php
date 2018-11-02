<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Cog\Contracts\Ban\Bannable as BannableContract;

class AuthenticateBanCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::where('email', $request->input('email'))->first();

        if ($user && $user instanceof BannableContract && $user->isBanned()) {
            return redirect()->back()->withInput()->withErrors([
                'email' => 'This account is blocked.',
            ]);
        }

        return $next($request);
    }
}
