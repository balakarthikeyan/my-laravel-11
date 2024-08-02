<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class Helper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public static function parseToYmd($date)
    {
        return Carbon::parse($date)->format('Y-m-d'); 
    }
}
