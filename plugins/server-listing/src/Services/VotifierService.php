<?php

namespace Azuriom\Plugin\ServerListing\Services;

use phpseclib3\Crypt\RSA;
use Exception;

class VotifierService
{
    /**
     * Sends a vote to a Minecraft server using the Votifier protocol.
     *
     * @param string $host The Votifier host (IP or domain).
     * @param int $port The Votifier port.
     * @param string $publicKey The Votifier public key.
     * @param string $username The Minecraft username.
     * @return bool True on success, false on failure.
     */
    public function sendVote(string $host, int $port, string $publicKey, string $username): bool
    {
        try {
            // 1. Create the vote message
            $message = "VOTE\n{$username}\n" . config('app.name') . "\n" . time() . "\n";

            // 2. Encrypt the message with the public key
            $rsa = RSA::load($publicKey);
            $rsa->withPadding(RSA::PADDING_PKCS1);

            $encryptedMessage = $rsa->encrypt($message);

            // 3. Establish TCP connection and send data
            $socket = fsockopen($host, $port, $errno, $errstr, 10);
            if (!$socket) {
                // Log the connection error for debugging
                \Log::error("Votifier connection failed for host {$host}: {$errstr}");
                return false;
            }

            fwrite($socket, $encryptedMessage);
            fclose($socket);

            return true;
        } catch (Exception $e) {
            // Log the exception for debugging
            \Log::error("Votifier vote failed for user {$username} on host {$host}: " . $e->getMessage());
            return false;
        }
    }
}
