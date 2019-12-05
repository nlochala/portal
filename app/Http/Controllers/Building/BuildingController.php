<?php

namespace App\Http\Controllers;

use App\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
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
        return view('room.building_index');
    }

}
