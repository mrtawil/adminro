<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Forms
    |--------------------------------------------------------------------------
    |
    | Assign default forms records
    |
    */

    'forms' => [
        'select' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Owner Settings Manager
    |--------------------------------------------------------------------------
    |
    | Two static methods should be included in the class assigned
    | - removeOwnerSettings
    | - storeOwnerSettings
    |
    */

    'model_owner_settings_manager' => null,

    /*
    |--------------------------------------------------------------------------
    | Select page limit
    |--------------------------------------------------------------------------
    |
    | The number of select items sent per response
    |
    */

    'select_page_limit' => 10,
];
