<?php

namespace App\Http\Controllers;

use App\Building;
use App\RoomType;

class RoomController extends Controller
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
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $buildings = Building::all();
        $room_types = RoomType::all();

        return view('room.room_index', compact('buildings', 'room_types'));
    }
}
