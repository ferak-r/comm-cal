<?php

namespace App\Classes;

class Rules
{
    //open/closed principle (SOLID)
    protected $clients;

    public function __construct($clients)
    {
        $this->clients = $clients;
    }
    public function depositWithoutCommission($inputs, $key)
    {
        return $this->clients->depositWithoutCommission($inputs, $key);

    }

    public function withdrawWithoutCommission($inputs, $key)
    {
        return $this->clients->withdrawWithoutCommission($inputs, $key);
    }

}
