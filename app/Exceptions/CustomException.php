<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class CustomException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        // Additional logic to report the exception, if needed
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request)
    {
        return response()->view('errors.custom', [], 500);
    }
}
