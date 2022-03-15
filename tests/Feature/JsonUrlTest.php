<?php

namespace Tests\Feature;

use Tests\TestCase;

class JsonUrlTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    //todo I have no time for write enterprise phpunit or other automation test
    public function tes_json_url()
    {
        $response = $this->get('/import');

        $response->assertStatus(200);
    }
}
