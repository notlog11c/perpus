<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Request;

class UserShouldVerified
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
        $response = $next($request);

        if (auth()->check() && !auth()->user()->is_verified) {
            auth()->logout();

            Session::flash('flash_notification', [
                'level' => 'warning',
                'message' => 'Akun anda belum aktif, Silahkan klik link verifikasi yang telah dikirim di email anda!'
            ]);

            return redirect('/login');
        }

        return $response;
    }
}
