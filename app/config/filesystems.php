<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'endpoint' => env('AWS_URL'),
        ],

        'google_backup_v1' => [
            'driver' => 'google',
            'clientId' => env('DB_GOOGLE_DRIVE_CLIENT_ID_V1'),
            'clientSecret' => env('DB_GOOGLE_DRIVE_CLIENT_SECRET_V1'),
            'refreshToken' => env('DB_GOOGLE_DRIVE_REFRESH_TOKEN_V1'),
            'folderId' => env('DB_GOOGLE_DRIVE_FOLDER_ID_V1'),
        ],

        'google_backup_v2' => [
            'driver' => 'google',
            'clientId' => env('DB_GOOGLE_DRIVE_CLIENT_ID_V2'),
            'clientSecret' => env('DB_GOOGLE_DRIVE_CLIENT_SECRET_V2'),
            'refreshToken' => env('DB_GOOGLE_DRIVE_REFRESH_TOKEN_V2'),
            'folderId' => env('DB_GOOGLE_DRIVE_FOLDER_ID_V2'),
        ],

    ],

];
