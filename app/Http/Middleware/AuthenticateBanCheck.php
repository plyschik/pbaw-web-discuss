<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Illuminate\Support\Facades\DB;

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
            $ban  = DB::table('bans')->where('bannable_id', $user->id)->first();
            return redirect()->back()->withInput()->withErrors([
                'email' => 'Your account has been suspended until ' . $ban->expired_at . ', reason: '. $ban->comment,
            ]);
        }

        return $next($request);
    }
}
