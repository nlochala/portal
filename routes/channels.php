<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\ParentMessage;

Broadcast::channel('employees', function ($user) {
    return is_employee();
});

Broadcast::channel('guardians', function ($user) {
    return is_guardian();
});

Broadcast::channel('students', function ($user) {
    return is_student();
});

Broadcast::channel('all', function ($user) {
    return auth()->check();
});

Broadcast::channel('user.{user_uuid}', function ($user, $user_uuid) {
    return $user->uuid === $user_uuid;
});

