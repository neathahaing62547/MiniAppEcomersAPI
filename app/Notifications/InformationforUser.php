<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InformationforUser extends Notification
{
    use Queueable;
    
    public $title;
    public $message;

    public function __construct($title , $message)
    {
        $this->title = $title;
        $this->message = $message;

    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }
  public function toMail($notifiable)
{
    return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject($this->title)
                ->view('email.noftification', [
                    'title' => $this->title,
                    'bodyMessage' => $this->message
                ]);
}
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */ 
    public function toArray(object $notifiable): array
    {
        return [
               
        ];
    }
}
