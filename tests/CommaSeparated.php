<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Page;

class CommaSeparated extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test comma-separated values work
     */
    public function it_gets_comma_separated()
    {
        // $page =
    }
}
