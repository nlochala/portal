<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class OAuthController extends Controller
{
    /**
     * Send user to microsoft to login.
     *
     * @return RedirectResponse
     */
    public function login()
    {
        if ($user = auth()->user()) {
            return redirect()->to('/');
        }

        return redirect()->to('login/microsoft');
    }

    /**
     * Logout from the portal.
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        auth()->logout();
        return redirect()->to('/');
    }
}
