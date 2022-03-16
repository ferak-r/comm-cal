<?php

use JetBrains\PhpStorm\Pure;

if(!function_exists('get_json_decode_URL')){
    /**
     * @throws Exception
     */
    function get_json_decode_URL($url)
    {
        try{
            $content = file_get_contents($url);
        }catch (Exception $e){
            throw new \Exception("Can not Reach to Url");
        }
        $result = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE)  // OR json_last_error() !== 0
            throw new Exception(error_invalid_json($result));

        //return json_decode($content), true);
        return $result;
    }
}

if(!function_exists('error_invalid_json')){
    function error_invalid_json($json):string
    {
        foreach ($json as $string) {
            echo 'Decoding: ' . $string;
            json_decode($string);
            return match (json_last_error()) {
                JSON_ERROR_NONE => ' - No errors',
                JSON_ERROR_DEPTH => ' - Maximum stack depth exceeded',
                JSON_ERROR_STATE_MISMATCH => ' - Underflow or the modes mismatch',
                JSON_ERROR_CTRL_CHAR => ' - Unexpected control character found',
                JSON_ERROR_SYNTAX => ' - Syntax error, malformed JSON',
                JSON_ERROR_UTF8 => ' - Malformed UTF-8 characters, possibly incorrectly encoded',
                default => ' - Unknown error',
            };
        }

        return PHP_EOL;
    }
}

if (!function_exists('getWeekendDate')) {
    function getWeekendDate($date):string
    {
        return date('Y-m-d', strtotime('next monday', strtotime($date)));
    }

}

if (!function_exists('roundUp')) {
    function roundUp(float $number, int $precision = 3): float|int
    {
        $fig = (int) str_pad('1', $precision, '0');
        return ceil($number * $fig) / $fig;

    }
}
if (!function_exists('getFirstDayOfWeek')) {
    function getFirstDayOfWeek($currentDate): string
    {
        $date = date_create($currentDate);
        $dayOfWeek = date('w', strtotime($currentDate));

        $howDayBefore = $dayOfWeek -1 ." day";

        date_sub($date, date_interval_create_from_date_string($howDayBefore));

        return date_format($date, "Y-m-d");
    }
}
if (!function_exists('getLastDayOfWeek')) {
    function getLastDayOfWeek($currentDate): string
    {
        $date = date_create($currentDate);
        $dayOfWeek = date('w', strtotime($currentDate));

        $howDayAfter = 7 - $dayOfWeek." day";

        date_add($date, date_interval_create_from_date_string($howDayAfter));

        return date_format($date, "Y-m-d");

    }

    if (!function_exists('currencyConvertByURL')) {
        /**
         * @throws Exception
         */
        function currencyConvertByURL($amount, $currency, $reverse = 0): float
        {
            //get_json_decode_URL is own helper function
            try{
                $exchange = get_json_decode_URL(config('constants.exchange_url'));
            } catch (\Exception $e) {
                throw new Exception($e);
            }

            $rateBaseElement = config('constants.rate_element');
            $rate = $exchange[$rateBaseElement][$currency];

            return $reverse ? (float)$amount * $rate : (float)$amount / $rate;
        }
    }
}

/*not used
if(!function_exists('csv_array')){
    function csv_array():array
    {

        $filename = config('constants.csv_file_name');

// The nested array to hold all the arrays
        $csv = [];

// Open the file for reading
        if (($h = fopen($filename, config('constants.ignore_new_line'))) !== FALSE)
        {
            // Each line in the file is converted into an individual array that we call $data
            // The items of the array are comma separated
            while (($data = fgetcsv($h, 1000)) !== FALSE)
            {
                // Each individual array is being pushed into the nested array
                $csv[] = $data;
            }

            // Close the file
            fclose($h);
        }

        return $csv;

    }
}

if(!function_exists('csv_to_array')){
    function csv_to_array($fileName):array
    {
        $csv = array_map('str_getcsv', file($fileName));
        $result = array();
        foreach($csv as $data)
            $result[] = $data;

        return $result;
    }
}
*/