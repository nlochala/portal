<?php

namespace App\Http\Controllers;

class OAuthController extends Controller
{
    public function login()
    {
        if ($user = auth()->user()) {
            $employee = $user->person->employee;
            return redirect()->to("employee/$employee->uuid/profile");
        }

        return redirect()->to('login/microsoft');
    }
}
