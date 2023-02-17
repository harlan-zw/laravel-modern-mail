<?php

return [

    'mjml_binary_mode' => env('MJML_BINARY_MODE', 'detect'),

    'mjml_binary_path' => env('MJML_BINARY_PATH', 'mjml'),

    'mjml_validate' => env('MJML_VALIDATE', 'warning'),

    /**
     * Modify the behaviour of the html-to-text plugin.
     *
     * 'do_links' => 'inline', // 'none'
        // 'inline' (show links inline)
        // 'nextline' (show links on the next line)
        // 'table' (if a table of link URLs should be listed after the text.
        // 'bbcode' (show links as bbcode)

     * 'width' => 70,
        //  Maximum width of the formatted text, in columns.
        //  Set this value to 0 (or less) to ignore word wrapping
        //  and not constrain text to a fixed-width column.
     * */
    'html_to_text_options' => [],

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
        'default' => [
            'headers' => [
                'tag' => 'X-Array-Tag',
                'track-opens' => 'X-Track-Opens',
                'track-clicks' => 'X-Track-Clicks',
            ],
            'header_on_value' => 'on',
            'header_off_value' => 'off',
        ],
        'mailgun' => [
            'headers' => [
                'tag' => 'X-Mailgun-Tag',
                'track-opens' => 'X-Mailgun-Track-Opens',
                'track-clicks' => 'X-Mailgun-Track-Clicks',
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
