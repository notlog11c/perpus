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
            $link = url('auth/resend-verification') . '?email=' . urlencode(auth()->user()->email);
            
            auth()->logout();

            Session::flash('flash_notification', [
                'level' => 'warning',
                'message' => "Akun anda belum aktif, Silahkan klik link verifikasi yang telah dikirim di email anda! <a class='alert-link' href='$link'>Kirim Ulang VerifikasI</a>"
            ]);

            return redirect('/login');
        }

        return $response;
    }
}
