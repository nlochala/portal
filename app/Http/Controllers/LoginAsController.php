<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginAsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request, User $user)
    {
        auth()->login($user, true);

        return redirect()->to('/');
    }
}
