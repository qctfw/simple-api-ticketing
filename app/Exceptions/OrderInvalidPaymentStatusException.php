<?php

namespace App\Exceptions;

use Exception;

class OrderInvalidPaymentStatusException extends Exception
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
                'message' => 'Status pembayaran untuk order ini tidak valid untuk request ini'
            ], 404);
        }

        return false;
    }
}
