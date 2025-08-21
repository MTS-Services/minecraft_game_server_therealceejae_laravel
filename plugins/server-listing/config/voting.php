<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Vote Cooldown Settings
    |--------------------------------------------------------------------------
    */
    'cooldown' => [
        'hours' => env('VOTE_COOLDOWN_HOURS', 12),
        'per_ip' => env('VOTE_COOLDOWN_PER_IP', true),
        'per_username' => env('VOTE_COOLDOWN_PER_USERNAME', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Votifier Settings
    |--------------------------------------------------------------------------
    */
    'votifier' => [
        'enabled' => env('VOTIFIER_ENABLED', true),
        'timeout' => env('VOTIFIER_TIMEOUT', 10), // seconds
        'retry_attempts' => env('VOTIFIER_RETRY_ATTEMPTS', 3),
        'retry_delay' => env('VOTIFIER_RETRY_DELAY', 30), // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Vote Validation
    |--------------------------------------------------------------------------
    */
    'validation' => [
        'captcha_enabled' => env('VOTE_CAPTCHA_ENABLED', true),
        'rate_limit' => [
            'max_attempts' => env('VOTE_RATE_LIMIT_ATTEMPTS', 5),
            'decay_minutes' => env('VOTE_RATE_LIMIT_DECAY', 60),
        ],
        'username_validation' => [
            'min_length' => 3,
            'max_length' => 16,
            'pattern' => '/^[a-zA-Z0-9_]+$/',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Vote Rewards
    |--------------------------------------------------------------------------
    */
    'rewards' => [
        'enabled' => env('VOTE_REWARDS_ENABLED', true),
        'default_commands' => [
            'give {username} diamond 1',
            'money give {username} 100',
            'broadcast &a{username} &fhas voted for the server!'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */
    'statistics' => [
        'enabled' => env('VOTE_STATISTICS_ENABLED', true),
        'cleanup_after_days' => env('VOTE_CLEANUP_DAYS', 180),
        'top_voters_count' => env('TOP_VOTERS_COUNT', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Anti-Fraud Settings
    |--------------------------------------------------------------------------
    */
    'anti_fraud' => [
        'enabled' => env('VOTE_ANTI_FRAUD_ENABLED', true),
        'max_votes_per_day_per_ip' => env('MAX_VOTES_PER_DAY_PER_IP', 5),
        'blocked_ips' => env('VOTE_BLOCKED_IPS', ''),
        'vpn_detection' => env('VOTE_VPN_DETECTION', false),
    ],
];
