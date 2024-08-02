<?php

namespace App\Helpers;

use Illuminate\Support\Str;
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
     * Carbon Method
     *
     * @return response()
     */
    public static function parseToYmd($date)
    {
        // $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        return Carbon::parse($date)->format('Y-m-d'); 
    }

    /**
     * Once Method
     *
     * @return response()
     */
    public static function randomOnceMethod()
    {
        return once(function () {
            return Str::random(10);
        });
    }
}
