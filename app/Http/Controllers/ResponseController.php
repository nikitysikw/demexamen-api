<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\MessageBag;

class ResponseController
{
    public static function toResponseJSON(int $status, $data)
    {
        // errors
        if ($status >= 400 && $status < 500) {
            return response()->json(
                [
                    "errors" => $data
                ],
                $status
            );
        }

        if ($status >= 200 && $status < 300) {
            return response()->json($data, $status);
        }

        return response()->json($data, $status);
    }
}
