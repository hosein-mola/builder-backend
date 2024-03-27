<?php

namespace App\Types;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApiResponse
{
    public static function success($data = null, $messages = [], $statusCode = 200, $logData = null)
    {
        if ($logData !== null) {
            self::logData($logData);
        } else {
            self::logStatusCode($statusCode);
        }

        return response()->json([
            'isSuccessful' => true,
            'collection' => $data,
            'messages' => self::formatMessages($messages)
        ], $statusCode);
    }

    public static function fail($errors = [], $statusCode = 400, $logData = null)
    {
        $trackId = Str::uuid(); // Generate a UUID for tracking the error

        if ($logData !== null) {
            self::logData(array_merge(['trackId' => $trackId], $logData));
        } else {
            self::logStatusCode($statusCode);
        }

        return response()->json([
            'isSuccessful' => false,
            'trackId' => $trackId,
            'errors' => self::formatErrors($errors)
        ], $statusCode);
    }

    private static function formatMessages($messages)
    {
        return array_map(function ($message) {
            return ['title' => $message['title'] ?? null, 'description' => $message['description'] ?? null];
        }, $messages);
    }

    private static function formatErrors($errors)
    {
        return array_map(function ($error) {
            return ['title' => $error['title'] ?? null, 'description' => $error['description'] ?? null];
        }, $errors);
    }

    private static function logData($logData)
    {
        Log::error(json_encode($logData));
    }

    private static function logStatusCode($statusCode)
    {
        $timestamp = now()->toDateTimeString();
        Log::error("Status Code: $statusCode. Timestamp: $timestamp");
    }
}
