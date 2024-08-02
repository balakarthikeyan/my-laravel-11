<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CookieController extends Controller
{

    /**
     * Write code on Cookie Set Method
     *
     * @return response()
     */
    public function setCookieMethod()
    {
        Cookie::queue('test-cookie', 'Cookie setup done via Cookie Facade', 120);

        return response()->json(['Cookie set successfully.'])->cookie(
            'test-cookie-2', 'Cookie setup done via Request Response', 120
        );
    }

    /**
     * Write code on Cookie Get Method
     *
     * @return response()
     */
    public function getCookieMethod(Request $request)
    {
        $cookie_value1 = Cookie::get('test-cookie');
        $cookie_value2 = $request->cookie('test-cookie-2');

        dd($cookie_value1, $cookie_value2);
    }

    /**
     * Write code on Cookie Delete Method
     *
     * @return response()
     */
    public function deleteCookieMethod()
    {
        Cookie::forget('test-cookie');
        Cookie::forget('test-cookie-2');
  
        dd('Cookie removed successfully.');
    }

    /**
     * Write code on Cookie Set Method
     *
     * @return response()
     */
    public function getSessionMethod()
    {
        $allSessions = session()->all();
        $allSessions = Session::all();
        dd($allSessions);
    }
}
