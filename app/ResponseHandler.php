<?php

namespace App;

class ResponseHandler
{
    public static function response($data = null, $isError = false)
    {
        $response = [
            'error' => $isError,
            'data' => $data
        ];

        echo json_encode($response);
        exit();
    }
}