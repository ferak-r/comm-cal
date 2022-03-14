<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Constants Name
    |--------------------------------------------------------------------------
    |
    | All Defined Constents in Project save in this file.
    |
    */
        'base_currency' => env('BASE_CURRENCY', 'EUR'),

        'base_element' => env('BASE_CURRENCY_ELEMENT_IN_URL', 'base'),

        'rate_element' => env('RATE_CURRENCY_ELEMENT_IN_URL', 'rates'),

        'exchange_url' => env('EXCHANGE_RATE_URL', 'https://developers.paysera.com/tasks/api/currency-exchange-rates'),

        'ignore_new_line' => env('FILE_IGNORE_NEW_LINES', 'r'),

        'csv_file_name' => env('CSV_FILE_NAME', 'input.csv'),

        'deposit_commission_percent' => env('DEPOSIT_COMMISSION_PERCENT', 0.03),

        'business_withdraw_commission_percent' => env('BUSINESS_WITHDRAW_COMMISSION_PERCENT', 0.5),

        'private_withdraw_commission_percent' => env('PRIVATE_WITHDRAW_COMMISSION_PERCENT', 0.3),
     ];
