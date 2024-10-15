<?php

namespace App\Helpers;

/**
 * Format response.
 */
class ResponseFormatter
{
    /**
     * API Response
     *
     * @var array
     */
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => [
                'title' => null,
                'body' => null,
            ],
        ],
        'data' => null,
    ];

    /**
     * Give success response.
     */
    public static function success($data = null, $message = null)
    {
        self::$response['meta']['message']['title'] = 'Berhasil';
        self::$response['meta']['message']['body'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    /**
     * Give error response.
     */
    public static function error($data = null, $message = null, $code = 400)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message']['title'] = 'Gagal';
        self::$response['meta']['message']['body'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    /**
     * Give unauthorized response.
     */
    public static function unauthorized($data = null, $message = null)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = 401;
        self::$response['meta']['message']['title'] = 'Gagal';
        self::$response['meta']['message']['body'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    /**
     * Give not found response.
     */

    public static function notFound($data = null, $message = null)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = 404;
        self::$response['meta']['message']['title'] = 'Gagal';
        self::$response['meta']['message']['body'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }
}
