<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOTP extends Notification
{
    use Queueable;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail']; // Hum email ke zariye bhej rahe hain
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Login OTP - Your Store')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your one-time password (OTP) for logging in is:')
            ->line('**' . $this->otp . '**')
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not request this, please ignore this email.');
    }
}