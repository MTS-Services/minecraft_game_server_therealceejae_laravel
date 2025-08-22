<?php

namespace Azuriom\Plugin\ServerListing\Services;

use Illuminate\Support\Facades\Log;
use Exception;
use phpseclib3\Crypt\RSA;

class VotifierService
{
    protected $publicKey;
    protected $host;
    protected $port;

    public function __construct($host, $port, $publicKey)
    {
        $this->host = $host;
        $this->port = $port;
        $this->publicKey = $this->formatPublicKey($publicKey);
    }

    /**
     * Format the public key to proper PEM format
     */
    protected function formatPublicKey($key)
    {
        // Remove any existing headers/footers and whitespace
        $key = preg_replace('/\s+/', '', $key);
        $key = str_replace(['-----BEGIN PUBLIC KEY-----', '-----END PUBLIC KEY-----'], '', $key);
        $key = str_replace(['-----BEGIN RSA PUBLIC KEY-----', '-----END RSA PUBLIC KEY-----'], '', $key);

        // Split into 64-character lines
        $key = chunk_split($key, 64, "\n");

        // Add proper PEM headers
        return "-----BEGIN PUBLIC KEY-----\n" . $key . "-----END PUBLIC KEY-----\n";
    }

    public function sendVote($username, $serviceName = 'MinecraftMP', $address = null, $timestamp = null)
    {
        try {
            $address = $address ?: request()->ip();
            $timestamp = $timestamp ?: time();

            // Create vote data string
            $voteData = "VOTE\n{$serviceName}\n{$username}\n{$address}\n{$timestamp}\n";

            // Log the vote data for debugging
            Log::info('Votifier vote data: ' . str_replace("\n", "\\n", $voteData));

            // Encrypt the vote data
            $encryptedData = $this->encryptData($voteData);

            if (!$encryptedData) {
                throw new Exception('Failed to encrypt vote data');
            }

            // Send to Votifier
            $response = $this->sendToVotifier($encryptedData);

            return [
                'success' => true,
                'response' => $response,
                'message' => 'Vote sent successfully'
            ];

        } catch (Exception $e) {
            Log::error('Votifier Error: ' . $e->getMessage());

            return [
                'success' => false,
                'response' => null,
                'message' => $e->getMessage()
            ];
        }
    }

    protected function encryptData($data)
    {
        try {
            Log::info('Attempting to encrypt data with public key');
            Log::info('Public key format check: ' . substr($this->publicKey, 0, 50) . '...');

            // Try with OpenSSL first
            $publicKey = openssl_pkey_get_public($this->publicKey);

            if ($publicKey) {
                // Get key details for debugging
                $keyDetails = openssl_pkey_get_details($publicKey);
                if ($keyDetails) {
                    Log::info('Key type: ' . $keyDetails['type'] . ', Key size: ' . $keyDetails['bits']);
                }

                // Encrypt the data
                $encrypted = '';
                $result = openssl_public_encrypt($data, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);

                // Free the key resource
                if (is_resource($publicKey)) {
                    openssl_pkey_free($publicKey);
                }

                if ($result) {
                    Log::info('Data encrypted successfully with OpenSSL, length: ' . strlen($encrypted));
                    return $encrypted;
                }
            }

            // If OpenSSL fails, try with phpseclib3
            Log::info('OpenSSL failed, trying phpseclib3...');
            try {
                $rsa = RSA::loadPublicKey($this->publicKey);

                $encrypted = $rsa->encrypt($data, RSA::ENCRYPTION_PKCS1);
                Log::info('Data encrypted successfully with phpseclib3, length: ' . strlen($encrypted));
                return $encrypted;

            } catch (Exception $e) {
                Log::error('phpseclib3 encryption failed: ' . $e->getMessage());
            }

            // Get OpenSSL errors for debugging
            $opensslError = '';
            while ($msg = openssl_error_string()) {
                $opensslError .= $msg . '; ';
            }

            throw new Exception('Both OpenSSL and phpseclib3 encryption failed. OpenSSL errors: ' . $opensslError);

        } catch (Exception $e) {
            Log::error('Encryption Error: ' . $e->getMessage());
            return false;
        }
    }

    protected function sendToVotifier($encryptedData)
    {
        Log::info("Connecting to Votifier at {$this->host}:{$this->port}");

        $socket = fsockopen($this->host, $this->port, $errno, $errstr, 10);

        if (!$socket) {
            throw new Exception("Connection failed: {$errstr} ({$errno})");
        }

        Log::info('Connected to Votifier, sending data...');

        // Send the encrypted data
        $bytesWritten = fwrite($socket, $encryptedData);
        Log::info("Sent {$bytesWritten} bytes to Votifier");

        // Read response (optional)
        $response = fread($socket, 1024);
        fclose($socket);

        Log::info('Votifier response: ' . ($response ?: 'No response'));

        return $response;
    }

    public function testConnection()
    {
        try {
            $socket = fsockopen($this->host, $this->port, $errno, $errstr, 5);

            if (!$socket) {
                return [
                    'success' => false,
                    'message' => "Connection failed: {$errstr} ({$errno})"
                ];
            }

            fclose($socket);

            return [
                'success' => true,
                'message' => 'Connection successful'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Test the public key encryption
     */
    public function testEncryption()
    {
        try {
            $testData = "TEST\nMinecraftMP\ntestuser\n127.0.0.1\n" . time() . "\n";
            $encrypted = $this->encryptData($testData);

            if ($encrypted) {
                return [
                    'success' => true,
                    'message' => 'Encryption test successful',
                    'encrypted_length' => strlen($encrypted)
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Encryption test failed'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Encryption test failed: ' . $e->getMessage()
            ];
        }
    }
}
