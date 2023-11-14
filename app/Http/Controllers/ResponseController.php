<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    //
    /**
     * Return success or error dependent on trueness or falsity of arg
     * @param string $comment
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public static function simple($status, $data = [])
    {
        return $status ? response()->json(
            [
                "status" => "OK",
                "statusCode" => 1,
                "message" => "Successful",
                "data" => $data
            ],
            200
        ) :
            response()->json(
                [
                    "status" => $status,
                    "statusCode" => -1,
                    "message" => "Failed",
                    "data" => $data
                ],
                404
            );
    }
}
