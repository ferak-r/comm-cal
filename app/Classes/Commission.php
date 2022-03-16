<?php

namespace App\Classes;

class Commission
{
    private float $amountWithCommission;
    private float $percent;

    public function __construct($amountWithCommission, $percent = 0)
    {
        $this->amountWithCommission = $amountWithCommission;
        $this->percent = $percent;
    }

    public function calculate(): float
    {
       return  $this->amountWithCommission * ($this->percent / 100);
    }

}
