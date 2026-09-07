<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk based on a series of
    | paths. By setting these, you may specify where your views are located
    | and how they should be loaded. The default path is for Laravel's
    | default views, which may be useful for your application as well.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option defines the path to all compiled/blade templates, which is
    | usually stored in the storage directory. It's important that the path
    | to the compiled views is writable so they can be cached.
    |
    */

    'compiled' => realpath(storage_path('framework/views')),

];
