<?php

namespace App\Exceptions;

use Exception;

class AuthenticationMethodAlreadyExists extends Exception
{

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return view('errors.auth-exists');
    }
}
