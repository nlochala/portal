<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

class HowToVideosController extends Controller
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

    /**
     * Show the videos channel.
     *
     * @return Factory|View
     */
    public function channel()
    {
        return view('videos.channel');
    }
}
