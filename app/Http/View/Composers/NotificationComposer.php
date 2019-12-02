<?php


namespace App\Http\View\Composers;

use Illuminate\View\View;

class NotificationComposer
{

    /**
     * @var array
     */
    private $notifications;

    /**
     * NotificationComposer constructor.
     */
    public function __construct()
    {
        $this->notifications = auth()->user() ? auth()->user()->unreadNotifications : [];
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('notifications', $this->notifications);
    }

}
