<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($message, $code = 200)
    {
        return response()->json(['message' => $message], $code);
    }

    public static function error($message, $code = 500)
    {
        return response()->json(['message' => $message], $code);
    }

    public static function data($data, $code = 200)
    {
        return response()->json(['data' => $data], $code);
    }

    public static function noData($code = 204)
    {
        return response()->json(null, $code);
    }
}
