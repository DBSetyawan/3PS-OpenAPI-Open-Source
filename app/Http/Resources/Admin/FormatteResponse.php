<?php

namespace App\Http\Resources\Admin;

class FormatteResponse
{
   protected static $response = [

        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null,
        ],
        'version' => [],

        'data' => null

   ];

   public static function success($version = [], $data = null, $message = null){
        
        self::$response['version'] = $version;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);

   }

   public static function error($data = null, $message = null, $code ){

        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data']['status'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
   }

}
