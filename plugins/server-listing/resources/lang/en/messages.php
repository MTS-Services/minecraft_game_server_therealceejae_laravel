<?php

return [
    'title' => 'Server Listing',
    'welcome' => 'Welcome on the minecraft server listing!',

    'buy' => 'Buy',

    'free' => 'Free',

    'periods' => [
        'hours' => 'hours',
        'days' => 'days',
        'weeks' => 'weeks',
        'months' => 'months',
        'years' => 'years',
    ],

    'fields' => [
        'name' => 'Name',
        'description' => 'Description',
        'category' => 'Category',
        'server_ip' => 'Server IP',
        'server_port' => 'Server Port',
        'website_url' => 'Website URL',
        'discord_url' => 'Discord URL',
        'banner_image' => 'Banner Image',
        'logo_image' => 'Logo Image',
        'version' => 'Version',
        'max_players' => 'Max Players',
        'current_players' => 'Current Players',
        'is_online' => 'Is Online',
        'is_premium' => 'Is Premium',
        'is_featured' => 'Is Featured',
        'is_approved' => 'Is Approved',
        'tags' => 'Tags',
        'vote_count' => 'Vote Count',
        'total_votes' => 'Total Votes',
        'last_ping' => 'Last Ping',
        'sort_order' => 'Sort Order',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'logo' => 'Logo',
        'image' => 'Image',
        'enabled' => 'Enabled',
        'chances' => 'Chances',
        'action' => 'Action',
        'slug' => 'Slug',
        'user' => 'User',
        'price' => 'Price',
        'amount' => 'Amount',
        'gateway' => 'Gateway',
        'coupon' => 'Coupon',
        'giftcard' => 'Giftcard',
        'code' => 'Code',
        'balance' => 'Balance',
        'featured' => 'Featured',
        'sort' => 'Sort',
        'global' => 'Global',
        'user_limit' => 'User Limit',
    ],

    'actions' => [
        'subscribe' => 'Subscribe',
        'manage' => 'Manage subscription',
        'move' => 'Move',
    ],

    'goal' => [
        'title' => 'Goal of the month',
        'progress' => ':count% completed',
    ],

    'recent' => [
        'title' => 'Recent Payments',
        'empty' => 'No recent payments',
    ],

    'top' => [
        'title' => 'Top customer',
    ],

    'cart' => [
        'title' => 'Cart',
        'success' => 'Your purchase has been successfully completed.',
        'guest' => 'You must be logged in to make a purchase.',
        'empty' => 'Your cart is empty.',
        'checkout' => 'Checkout',
        'clear' => 'Clear the cart',
        'pay' => 'Pay',
        'back' => 'Back to home',
        'total' => 'Total: :total',
        'payable_total' => 'Total to pay: :total',
        'credit' => 'Credit',

        'confirm' => [
            'title' => 'Pay?',
            'price' => 'Are you sure you want to buy this cart for :price.',
        ],

        'errors' => [
            'money' => 'You don\'t have enough money to make this purchase.',
            'execute' => 'An unexpected error occurred during payment, your purchase got refund.',
        ],
    ],

    'coupons' => [
        'title' => 'Coupons',
        'add' => 'Add a coupon',
        'error' => 'This coupon does not exist, has expired or can no longer be used.',
        'cumulate' => 'You cannot use this coupon with an other coupon.',
    ],

    'payment' => [
        'title' => 'Payment',
        'manual' => 'Manual payment',

        'empty' => 'No payment methods currently available.',

        'info' => 'Purchase #:id on :website: :items',
        'subscription' => ':package - Subscription (User #:user)',
        'error' => 'The payment could not be completed, please try again later.',
        'giftcards' => 'Giftcards',

        'success' => 'Payment completed, you\'ll receive your purchase in-game in less than a minute.',
        'pending' => 'Payment pending, you\'ll receive your purchase in-game once the payment is confirmed.',

        'webhook' => 'New payment on the server listing',
        'webhook_info' => 'Total: :total, ID: :id (:gateway)',
        'webhook_chargeback' => 'Payment chargeback on the server listing',
        'webhook_refund' => 'Payment refund on the server listing',
    ],

    'categories' => [
        'empty' => 'This category is empty.',
    ],

    'packages' => [
        'limit' => 'You have purchased the maximum possible for this packages.',
        'requirements' => 'You don\'t have the requirements to purchase this package.',
        'cumulate' => 'You cannot buy this package with an other from the same category in the same purchase.',
        'file' => 'Click here to download the file :file',
    ],

    'offers' => [
        'gateway' => 'Payment type',
        'amount' => 'Amount',

        'empty' => 'No offers are currently available.',
    ],

    'profile' => [
        'payments' => 'Your payments',
        'subscriptions' => 'Your subscriptions',
        'money' => 'Money: :balance',
    ],

    'giftcards' => [
        'title' => 'Giftcards',
        'error' => 'This gift card does not exist, has expired or can no longer be used.',
        'add' => 'Add a gift card',
        'notification' => 'You received a giftcard, the code is :code (:balance).',
        'pending' => 'A payment has already started for this giftcard. Complete the payment or wait a few minutes.',
    ],
];
