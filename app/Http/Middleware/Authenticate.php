<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $notificacion = array(
                'message' => 'Para utilizar este proceso es necesario iniciar sesión.',
                'alert-type' => 'warning'
            );

            return redirect()->route('user.login')->with($notificacion);
        }
    }
}
