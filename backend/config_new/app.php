<?php
return [
    /*
      |--------------------------------------------------------------------------
      | Encryption Key
      |--------------------------------------------------------------------------
      |
      | This key is used by the Illuminate encrypter service and should be set
      | to a random, 32 character string, otherwise these encrypted strings
      | will not be safe. Please do this before deploying an application!
      |
     */

    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'debug' => env('APP_DEBUG', true),
    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
    'PDF' => Barryvdh\DomPDF\PDF::class,

   'timezone' => 'Asia/Bangkok',
];
