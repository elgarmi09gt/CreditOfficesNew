<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    /** @test **/
    public function entreprise_dividende()
    {
        $this->assertEquals(4600,\App\Helpers\GetRatiosHelpers::dividende(7,2014));
    }
}
