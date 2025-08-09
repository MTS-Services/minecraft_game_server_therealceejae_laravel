<?php

namespace Azuriom\Plugin\ServerListing\Services;

use Illuminate\Support\Facades\Http;

class ServerStatusService
{
    /**
     * The base URL for the server status API.
     *
     * @var string
     */
    protected $baseUrl = 'https://api.mcsrvstat.us/3/';

    /**
     * Check the connection status of a server using a third-party API.
     *
     * @param string $serverIp The IP address of the server.
     * @param string|null $serverPort The port of the server (optional).
     * @return array The response containing the connection status and data.
     */
    public function checkServerStatus(string $serverIp, ?string $serverPort = null): array
    {
        // Check if serverIp is provided and not empty
        if (empty($serverIp)) {
            return [
                'success' => false,
                'message' => 'Server IP cannot be empty.',
                'code' => 400
            ];
        }

        // Construct the URL. Append the port if it's provided and not the default (25565).
        $url = $this->baseUrl . $serverIp;
        if (!empty($serverPort) && $serverPort != '25565') {
            $url .= ':' . $serverPort;
        }

        try {
            $response = Http::get($url);

            // Check for HTTP errors (e.g., 404, 500) from the API
            if ($response->failed()) {
                return [
                    'success' => false,
                    'message' => 'Failed to connect to the server status API.',
                    'code' => $response->status(),
                    'data' => $response->json()
                ];
            }

            // Decode the JSON response from the API
            $responseData = $response->json();

            // Check the status based on the provided logic
            $isOnline = isset($responseData['online']) ? $responseData['online'] : false;
            $versionContainsOffline = isset($responseData['version']) ? str_contains(strtolower($responseData['version']), 'offline') : false;
            $apiIp = isset($responseData['ip']) ? $responseData['ip'] : null;
            $isLocalIp = in_array($apiIp, ['127.0.0.1', 'localhost', '::1']);

            if ($isOnline && !$versionContainsOffline) {
                // Condition 1: online is true and version is not offline
                return [
                    'success' => true,
                    'message' => 'Connection successful. Server is online.',
                    'server_data' => $responseData,
                    'code' => 200
                ];
            } elseif ($isOnline && $versionContainsOffline) {
                // Condition 2: online is true and version contains offline
                return [
                    'success' => false,
                    'message' => 'Make sure your server is online.',
                    'server_data' => $responseData,
                    'code' => 200
                ];
            } elseif (!$isOnline && $isLocalIp) {
                // Condition 3: online is false and IP is local
                return [
                    'success' => false,
                    'message' => 'Please check the server ip and port.',
                    'server_data' => $responseData,
                    'code' => 200
                ];
            } else {
                // Condition 4: online is false and IP is not local
                return [
                    'success' => false,
                    'message' => 'Your server is offline.',
                    'server_data' => $responseData,
                    'code' => 200
                ];
            }
        } catch (\Exception $e) {
            // Catch any other exceptions during the HTTP request
            return [
                'success' => false,
                'message' => 'An unexpected error occurred while checking the server status.',
                'error' => $e->getMessage(),
                'code' => 500
            ];
        }
    }

    public function getCountryCode(string $ip): string
    {
        if (empty($ip)) {
            return '';
        }
        $response = Http::get('http://ip-api.com/json/' . $ip);
        return $response;
    }
}
