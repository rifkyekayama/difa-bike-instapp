<?php

return [
    /*
    |--------------------------------------------------------------------------
    | IMAP Host Address
    |--------------------------------------------------------------------------
    */
    'host' => env('IMAP_HOST'),

    /*
    |--------------------------------------------------------------------------
    | IMAP Host Port
    |--------------------------------------------------------------------------
    */
    'port' => env('IMAP_PORT', 993),

    /*
    |--------------------------------------------------------------------------
    | Encryption Protocol
    |--------------------------------------------------------------------------
    |
    | Supported: "ssl", "tls", "none"
    |
    */
    'encryption' => env('IMAP_ENCRYPTION', 'ssl'), // none/ssl/tls

    /*
    |--------------------------------------------------------------------------
    | Certification validate
    |--------------------------------------------------------------------------
    */
    'validate_cert' => env('IMAP_CERT', true),

    /*
    |--------------------------------------------------------------------------
    | Open in read only mode
    |--------------------------------------------------------------------------
    */
    'read_only' => env('IMAP_READONLY', false),

    /*
    |--------------------------------------------------------------------------
    | IMAP Server Username
    |--------------------------------------------------------------------------
    */
    'username' => env('IMAP_USERNAME'),

    /*
    |--------------------------------------------------------------------------
    | IMAP Server Password
    |--------------------------------------------------------------------------
    */
    'password' => env('IMAP_PASSWORD'),
];