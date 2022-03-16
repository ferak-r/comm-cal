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
        $amount = (float) $inputs[$key]['amount'];

        $firstDayOfWeek = getFirstDayOfWeek($currentDate);
        $lastDayOfWeek = getLastDayOfWeek($currentDate);
        $countThisWeek = 0;
        $sum = 0;

        $currencyEuro1000 = ($currency == "EUR")
            ? 1000
            : currencyConvertByURL(1000, $currency, -1);

        foreach ($inputs as $k => $input) {
            if ($countThisWeek <= 3
                && $input['user_id'] == $userId
                && $input['operation_type'] == "withdraw"
                && $k != $key
                && $currentDate >= $firstDayOfWeek
                && $currentDate <= $lastDayOfWeek
                && $currentDate >= $input['date']
                && $sum < $currencyEuro1000
            ) {
                $sum += $input['amount'];
                $countThisWeek++;
            }
        }
        $remainedCommissionFree = $currencyEuro1000 - $sum;

        if($remainedCommissionFree > 0)
            return $remainedCommissionFree;
        else
            return 0;
    }
}
