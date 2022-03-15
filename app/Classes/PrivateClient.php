<?php

namespace App\Classes;

use App\Contracts\Ruleable;

class PrivateClient implements Ruleable
{
    private array $inputs;
    private int $key;

    public function __construct($inputs,$key)
    {
        $this->inputs = $inputs;
        $this->key = $key;
    }

    public function depositWithoutCommission() : int
    {
        return 0;
    }

    public function withdrawWithoutCommission()
    {
        $inputs = $this->inputs;
        $key = $this->key;

        $userId = $inputs[$key]['user_id'];
        $currentDate = $inputs[$key]['date'];
        $currency = $inputs[$key]['currency'];
        $amount = (float)$inputs[$key]['amount'];

        $firstDayOfWeek = getFirstDayOfWeek($currentDate);
        $lastDayOfWeek = getLastDayOfWeek($currentDate);
        $countThisWeek = 0;
        $sum = 0;

        foreach($inputs as $k =>$input) {
            if ($countThisWeek <= 3
                && $input['user_id'] == $userId
                // && $input['operation_type'] == "withdraw"
                && $k != $key
                && $currentDate >= $firstDayOfWeek
                && $currentDate <= $lastDayOfWeek
                && $currentDate >= $input['date']
                && $sum < 1000
            ) {
                $currencyEuro1000 = ($currency == "EUR")
                    ?  $input['amount']
                    : currencyConvertByURL(1000 , $currency);
                $sum += $input['amount'];
                $countThisWeek++;
            }
        }
//
//        dd($sum,$amount,1000-$sum);//0 1200 1000
        if ($sum >= 0  & (($currencyEuro1000 - $sum) < $amount))
            return $currencyEuro1000 - $sum;
        else
            return $amount;
    }

}
