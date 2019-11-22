<?php

namespace App\Notifications;

use App\ParentMessage;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class ParentMessageSent extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var ParentMessage
     */
    public $message;

    /**
     * Create a new notification instance.
     *
     * @param ParentMessage $message
     */
    public function __construct(ParentMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast','slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'icon' => 'info',
            'title' => 'New Message: ',
            'text' => $this->message->subject,
        ]);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->to('@nlochala')
            ->content($this->message->subject);
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
            'notification_type' => 'Parent Message',
            'icon' => '<i class"fa fa-fw fa-user-plus text-info"></i>',
            'uri' => $this->message->body,
            'name' => $this->message->subject,
            'description' => $this->message->body,
            'created_at' => Carbon::parse($this->message->created_at)->diffForHumans(),
        ];
    }
}
