<?php

namespace App\Exceptions;

use Exception;

class TicketAlreadyUsedException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        if ($request->expectsJson())
        {
            return response()->json([
                'message' => 'Tiket sudah digunakan'
            ], 422);
        }

        return false;
    }
}
