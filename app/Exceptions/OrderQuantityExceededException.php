<?php

namespace App\Exceptions;

use Exception;

class OrderQuantityExceededException extends Exception
{
    public $max_qty;

    public function __construct(int $max_qty)
    {
        parent::__construct();

        $this->max_qty = $max_qty;
    }

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
            return response()->json(['message' => 'Kuantitas yang diorder melebihi dari yang seharusnya. (Maksimal: ' . $this->max_qty . ')'
            ], 422);
        }

        return false;
    }
}
