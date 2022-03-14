<?php

namespace App\Classes;

use PHPUnit\Framework\Exception;

class BaseTransactionActions
{
    public function getAction():string
    {
        //Get Input From CSV import.csv in public folder
        $inputArray = $this->getInput();
        $results = array();
        foreach($inputArray as $key => $inputs){

            $fee = $this->chooseRule($inputArray, $key);
            $strategy = new Commission($fee['withComm'],$fee['percent']);
            $commissionWithoutRoundConvert = $strategy->calculate();

            if($inputs['currency'] == "EUR") {
                $fee['withComm'] = currencyConvertByURL($fee['withComm'], $inputs['currency'], -1);
                $fee['withoutComm'] = currencyConvertByURL($fee['withoutComm'], $inputs['currency'], -1);
            }

            $inputArray[$key]["withoutComm"] = $fee['withoutComm'];
            $inputArray[$key]["withComm"] = $fee['withComm'];
            $inputArray[$key]["percent"] = $fee['percent'];
            $inputArray[$key]["base_commission"] = $commissionWithoutRoundConvert;
            $results[$key] = $inputArray[$key]["commission"] = roundUp($commissionWithoutRoundConvert);

        }
        foreach ($results as $result)
            echo $result."<br/>";
        return true;
    }

    /**
     * @throws \Exception
     */
    public function chooseRule(&$inputs, $key):array
    {
        $operation_type = $inputs[$key]['operation_type'];
        $amount = $inputs[$key]['amount'];
        $user_type = $inputs[$key]['user_type'];
        $currency = $inputs[$key]['currency'];

        $inputs[$key]['EurCurrency'] = ($currency == "EUR") ?  $amount
            : currencyConvertByURL($amount, $currency);

        switch ([$user_type, $operation_type]){
            case ['business', 'deposit']:
                $withoutComm = new Rules(new BusinessClient($inputs, $key));
                $amountWithoutCommission = $withoutComm->depositWithoutCommission($inputs, $key);
                $percent = config('constants.deposit_commission_percent');
                break;
            case ['business', 'withdraw']:
                $withoutComm = new Rules(new BusinessClient($inputs, $key));
                $amountWithoutCommission = $withoutComm->withdrawWithoutCommission($inputs, $key);
                $percent = config('constants.business_withdraw_commission_percent');
                break;
            case ['private', 'deposit']:
                $withoutComm = new Rules(new PrivateClient($inputs, $key));
                $amountWithoutCommission = $withoutComm->depositWithoutCommission($inputs, $key);
                $percent = config('constants.deposit_commission_percent');
                break;
            case ['private', 'withdraw']:
                $withoutComm = new Rules(new PrivateClient($inputs, $key));
                $amountWithoutCommission = $withoutComm->withdrawWithoutCommission($inputs, $key);
                $percent = config('constants.private_withdraw_commission_percent');
                break;
            default:
                throw new Exception("Input type is not valid!");
        }

        return array(
            'withComm' => $amount - $amountWithoutCommission,
            'withoutComm' => $amountWithoutCommission,
            'percent' => $percent
        );
    }

    public function getInput():array
    {
        $elements = array(
            "date",
            "user_id",
            "user_type",
            "operation_type",
            "amount",
            "currency"
        );

        // The nested array to hold all the arrays
        $linesString=  $result = $res = array();

        // Open the file default for reading
        $file = fopen(config('constants.csv_file_name'), config('constants.ignore_new_line'));

        while (!feof($file)) {
            $linesString[] = fgets($file);
        }

        fclose($file);
        if (is_array($linesString)) {
            foreach ($linesString as $everyLine => $str) {
                $result[$everyLine] = explode(',', preg_replace("/\r|\n/", "", $str));
            }
        }
        foreach ($result as $everyLine => $array) {
            foreach ($array as $key => $val) {
                $res[$everyLine][$elements[$key]] = $val;
            }
        }
        return $res;
    }
}