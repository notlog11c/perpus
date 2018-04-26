Klik Link Berikut Untuk Aktifasi Email Anda!
<a href="{{ $link = url('auth/verify', $token) . '?email=' . urlencode($user->email) }}">{{ $link }}</a>