<?php

namespace App\Classes;

use App\Contracts\Ruleable;

class BusinessClient implements Ruleable
{
    private array $inputs;
    private int $key;

    public function __construct($inputs, $key)
    {
        $this->inputs = $inputs;
        $this->key = $key;
    }
    /*
    public static function __callStatic(string $method, array $parameters)
    {
        if (!array_key_exists($method, self::$methods)) {
            throw new Exception('The ' . $method . ' is not supported.');
        }
        return call_user_func_array(self::$methods[$method], $parameters);
    }
    */

    public function depositWithoutCommission() : float
    {
        return 0;
    }

    public function withdrawWithoutCommission() : float
    {
        return 0;
    }

}
