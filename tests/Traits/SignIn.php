<?php

namespace Tests\Traits;

use App\User;

trait SignIn
{
    /**
     * Create a user and sign in as that user. If a user
     * object is passed, then sign in as that user.
     *
     * @param null $user
     * @return mixed
     */
    public function signIn($user = null)
    {
        $user = $user ? User::findOrFail($user) : User::find(1);
        auth()->login($user);

        return $user;
    }
}
