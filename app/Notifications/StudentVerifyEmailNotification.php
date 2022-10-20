<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class StudentVerifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * The email verification 6-digit code
     *
     * @var integer
     */
    public $token;

    /**
     * The user model
     *
     * @var App\Models\Student
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject(Lang::get('Email Verify Notification'))
        ->line(Lang::get('You are receiving this email because we received an email verification request from an username called :username.', ['username' => $this->user->username]))
        ->line(strval($this->token))
        ->line(Lang::get('This Verification Code will expired in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
        ->line(Lang::get('If you did not request an email verification, no further action is required.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
