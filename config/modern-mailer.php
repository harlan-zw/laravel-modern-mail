<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    |
    | Below you reference all components that should be loaded for your app.
    | By default all components from Blade UI Kit are loaded in. You can
    | disable or overwrite any component class or alias that you want.
    |
    */

    'services' => [
        'array' => [
            'headers' => [
                'tag' => 'X-Array-Tag',
                'track-opens' => 'X-Array-Track-Opens',
                'track-clicks' => 'X-Array-Track-Clicks',
            ],
            'header_on_value' => 'on',
            'header_off_value' => 'off',
        ],
        'mailgun' => [
            'headers' => [
                'tag' => 'X-Mailgun-Tag',
                'track.opens' => 'X-Mailgun-Track-Opens',
                'track.clicks' => 'X-Mailgun-Track-Clicks',
            ],
            'header_on_value' => 'on',
            'header_off_value' => 'off',
        ],
        'postmark' => [
            'headers' => [
                'tag' => 'X-PM-Tag',
                'track-opens' => 'X-PM-TrackOpens',
                'track-clicks' => 'X-PM-TrackLinks',
            ],
            'header_on_value' => 'true',
            'header_off_value' => 'false',
        ],
    ],

];
