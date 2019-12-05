<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsDisplayController extends Controller
{
    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = auth()->user()->notifications;
    }
}
