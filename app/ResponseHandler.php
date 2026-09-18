<?php

namespace App;

class ResponseHandler
{
    public static function response($data = null, $isError = false): never
    {
        $response = [
            'error' => $isError,
            'data' => $data
        ];

        echo json_encode($response);
        exit();
    }
}