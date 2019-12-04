<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Environment configuration key
    |--------------------------------------------------------------------------
    |
    | Config path, where current environment value stored
    */
    'env_config_key' => 'app.env',

    /**
     * Installer Settings
     */
    'installer' => [
        'path' => app_path('Install.php'),
        'class' => \App\Install::class,
    ],

    /**
     * Updater Settings
     */
    'updater' => [
        'path' => app_path('Update.php'),
        'class' => \App\Update::class,
    ],
];
