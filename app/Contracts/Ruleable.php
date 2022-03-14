<?php

namespace App\Contracts;

interface Ruleable
{
    public function depositWithoutCommission();
    public function withdrawWithoutCommission();
}
