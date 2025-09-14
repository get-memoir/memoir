<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Application description
    |--------------------------------------------------------------------------
    |
    | This value is the description of the application.
    |
    */

    'description' => env('APP_DESCRIPTION', 'Serious journaling for serious minds.'),

    /*
    |--------------------------------------------------------------------------
    | Show the marketing site
    |--------------------------------------------------------------------------
    |
    | This value enables the marketing site to be shown. If you
    | self host the application, you probably want to disable this since
    | you don't need to show the marketing site.
    |
    */

    'show_marketing_site' => env('SHOW_MARKETING_SITE', true),

    /*
    |--------------------------------------------------------------------------
    | Supported locales
    |--------------------------------------------------------------------------
    |
    | This value enables the supported locales of the application.
    |
    */

    'supported_locales' => ['en', 'fr'],

    /*
    |--------------------------------------------------------------------------
    | Use Resend to send transactional emails
    |--------------------------------------------------------------------------
    |
    | This value enables the use of Resend to send transactional emails.
    | If you self host the application, you probably want to disable this
    | since you don't need to send transactional emails.
    |
    */

    'use_resend' => env('USE_RESEND', false),

    /*
    |--------------------------------------------------------------------------
    | Permissions used by the application
    |--------------------------------------------------------------------------
    |
    | This value defines all the permissions used by the application.
    |
    */

    'permissions' => [
        [
            'name' => translate_key('Manage organizations settings'),
            'description' => translate_key('Allows managing organization settings such as name, description, and other details.'),
            'permissions' => [
                [
                    'key' => 'organization.edit',
                    'name' => translate_key('Edit organization'),
                    'description' => translate_key('Allows editing organization details such as name and settings, but not billing.'),
                ],
                [
                    'key' => 'organization.delete',
                    'name' => translate_key('Delete organization'),
                    'description' => translate_key('Allows deleting the organization.'),
                ],
                [
                    'key' => 'organization.permission.manage',
                    'name' => translate_key('Manage permissions, roles and groups'),
                    'description' => translate_key('Allows managing permissions, roles and groups within the organization.'),
                ],
            ],
        ],
    ],

];
