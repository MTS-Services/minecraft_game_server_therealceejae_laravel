<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckConnectionController extends Controller
{
    // public function checkConnection(Request $request)
    // {
    //     // Get the serverIp and serverPort from the request body
    //     $serverIp = $request->input('serverIp');
    //     $serverPort = $request->input('serverPort');

    //     // Check if serverIp is provided and not empty
    //     if (empty($serverIp)) {
    //         return response()->json(['success' => false, 'message' => 'Server IP cannot be empty.'], 400);
    //     }

    //     $baseUrl = "https://api.mcsrvstat.us/3/";

    //     // Construct the URL. Append the port if it's provided and not the default (25565).
    //     $url = $baseUrl . $serverIp;
    //     if (!empty($serverPort) && $serverPort != '25565') {
    //         $url .= ':' . $serverPort;
    //     }

    //     $response = Http::get($url);

    //     // Check for HTTP errors (e.g., 404, 500) from the API
    //     if ($response->failed()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to connect to the server status API.',
    //             'status' => $response->status(),
    //             'data' => $response->json()
    //         ], $response->status());
    //     }

    //     // Decode the JSON response from the API
    //     $responseData = $response->json();

    //     // Check the `online` key in the API response
    //     // Note: The API returns `online: true` even if the server is offline, but it provides `version: "Offline"`.
    //     if (isset($responseData['online']) && $responseData['online'] === true) {
    //         // Check if the server is actually online by looking at the version string.
    //         if (str_contains(strtolower($responseData['version']), 'offline')) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Make sure the server is online.',
    //                 'server_data' => $responseData
    //             ]);
    //         }

    //         // Server is online, return a success response with the data
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Connection successful.',
    //             'server_data' => $responseData
    //         ]);
    //     } else {
    //         $errorMessage = $responseData['offline'] ?? 'Server is offline';
    //         return response()->json([
    //             'success' => false,
    //             'message' => $errorMessage,
    //             'server_data' => $responseData
    //         ]);
    //     }
    // }

    public function checkConnection(Request $request)
    {
        // Get the serverIp and serverPort from the request body
        $serverIp = $request->input('serverIp');
        $serverPort = $request->input('serverPort');

        // Check if serverIp is provided and not empty
        if (empty($serverIp)) {
            return response()->json(['success' => false, 'message' => 'Server IP cannot be empty.'], 400);
        }

        $baseUrl = "https://api.mcsrvstat.us/3/";

        // Construct the URL. Append the port if it's provided and not the default (25565).
        $url = $baseUrl . $serverIp;
        if (!empty($serverPort) && $serverPort != '25565') {
            $url .= ':' . $serverPort;
        }

        try {
            $response = Http::get($url);

            // Check for HTTP errors (e.g., 404, 500) from the API
            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to connect to the server status API.',
                    'status' => $response->status(),
                    'data' => $response->json()
                ], $response->status());
            }

            // Decode the JSON response from the API
            $responseData = $response->json();

            // Check the status based on the provided logic
            $isOnline = isset($responseData['online']) ? $responseData['online'] : false;
            $versionContainsOffline = isset($responseData['version']) ? str_contains(strtolower($responseData['version']), 'offline') : false;

            // Corrected line: Check the IP from the API response, not the request.
            $apiIp = isset($responseData['ip']) ? $responseData['ip'] : null;
            $isLocalIp = in_array($apiIp, ['127.0.0.1', 'localhost', '::1']);

            if ($isOnline && !$versionContainsOffline) {
                // Condition 1: online is true and version is not offline
                return response()->json([
                    'success' => true,
                    'message' => 'Connection successful. Server is online.',
                    'server_data' => $responseData
                ]);
            } elseif ($isOnline && $versionContainsOffline) {
                // Condition 2: online is true and version contains offline
                return response()->json([
                    'success' => false,
                    'message' => 'Make sure your server is online.',
                    'server_data' => $responseData
                ]);
            } elseif (!$isOnline && $isLocalIp) {
                // Condition 3: online is false and IP is local
                return response()->json([
                    'success' => false,
                    'message' => 'Please check the server ip and port.',
                    'server_data' => $responseData
                ]);
            } else {
                // Condition 4: online is false and IP is not local
                return response()->json([
                    'success' => false,
                    'message' => 'Your server is offline.',
                    'server_data' => $responseData
                ]);
            }
        } catch (\Exception $e) {
            // Catch any other exceptions during the HTTP request
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while checking the server status.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
