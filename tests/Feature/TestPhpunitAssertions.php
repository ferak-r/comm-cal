<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestPhpunitAssertions extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAssertArrayHasKey()
    {
        $exchangeRates = ['usd' => 0.77, 'euro' => 0.63];

        $this->assertArrayHasKey('usd', $exchangeRates, 'Check if USD is available');
        $this->assertEquals(0.77, $exchangeRates['usd'], 'Test if USD rate is 0.77');
    }
}
