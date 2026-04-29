<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPassword
{
    use Queueable;

    public function toMail($notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Password Akun KostFinder')
            ->greeting('Halo dari KostFinder,')
            ->line('Kami menerima permintaan untuk mereset password akunmu.')
            ->line('Klik tombol di bawah ini untuk membuat password baru dan kembali masuk ke KostFinder.')
            ->action('Reset Password Sekarang', $resetUrl)
            ->line('Link ini hanya berlaku sementara demi menjaga keamanan akunmu.')
            ->line('Kalau kamu tidak merasa meminta reset password, abaikan email ini saja.')
            ->salutation('Salam hangat, Tim KostFinder');
    }
}
