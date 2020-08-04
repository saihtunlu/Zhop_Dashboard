<?php

use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('App', function ($user) {
    return $user;
});
// Broadcast::routes(['middleware' => ['auth:sanctum']], function () {
//     Broadcast::channel('order.{id}', function ($user, $id) {
//         return $user->id === (int) $id;
//     });
// });
// Broadcast::channel('order.{id}', function ($user, $id) {
//     return $user->id === (int) $id;
// });
