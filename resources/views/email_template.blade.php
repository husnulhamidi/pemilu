@component('mail::message')
Halo!<br>
Anda menerima email ini karena kami menerima permintaan setting ulang Password untuk akun anda.

@component('mail::button', ['url' => $data['url']])
Reset Password
@endcomponent

<p>Tautan reset password ini akan kedaluwarsa dalam {{ env('EXPIRED_TOKEN_CHANGE_PASSWORD') }} menit.<br>Jika anda tidak meminta pengaturan ulang kata sandi, tidak diperlukan tindakan lebih lanjut.</p>

Thanks,<br>
Admin 
@endcomponent
