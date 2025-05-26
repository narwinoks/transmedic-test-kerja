<?php

namespace App;

use Illuminate\Http\JsonResponse;

/**
 * @author narnowin195@gmail.com
 */
if (! function_exists('success')) {
    function success($message = '', $resource = null, $statusCode = 200): JsonResponse
    {
        $data = $resource ? (is_array($resource) ? $resource : json_decode(
            $resource->toResponse(request())->getContent(),
            true
        )) : [];

        return response()->json(array_merge($message, $data), $statusCode);
    }
}
if (! function_exists('error')) {
    function error($message = [], $statusCode = 400, $error = [], $data = []): JsonResponse
    {
        return response()->json(array_merge($message, $error, $data), $statusCode);
    }
}
