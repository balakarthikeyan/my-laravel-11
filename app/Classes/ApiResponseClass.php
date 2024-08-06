<?php

namespace App\Classes;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiResponseClass
{
    public static function rollback($e, $message = "Something went wrong! Process not completed")
    {
        DB::rollBack();
        Log::info($e);
        throw new HttpResponseException(self::sendResponse($message, $e, 500));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public static function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'status'  => $code,
        ];
        if (!empty($result)) {
            $response['data'] = $result;
        }
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public static function sendError($message, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'status'  => $code,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, $code);
    }
}
