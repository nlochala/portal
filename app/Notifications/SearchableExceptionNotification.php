<?php

namespace App\Notifications;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class SearchableExceptionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $exceptionMessage;
    private $entity;
    private $name;

    /**
     * Create a new notification instance.
     *
     * @param $exception
     * @param $entity
     * @param $name
     */
    public function __construct(Exception $exception, $entity, $name)
    {
        $this->exceptionMessage = $exception->getMessage();
        $this->entity = $entity;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Return the formatted slack message.
     *
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $title = $this->name.' ID: '.$this->entity->id;
        $url = url(strtolower($this->name).'/'.$this->entity->uuid);
        $content = $this->exceptionMessage;

        return (new SlackMessage)
            ->from(env('SLACK_FROM'), env('SLACK_ICON'))
            ->to(env('SLACK_CHANNEL'))
            ->content('Algolia Searchable Exception')
            ->attachment(static function ($attachment) use ($title, $url, $content) {
                $attachment->title($title, $url)
                           ->content($content);
            });
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
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
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
