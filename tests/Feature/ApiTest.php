<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * Test that submission api returs text sent to it.
     *
     * @return void
     */
    public function testSubmissionIndex()
    {
        $response = $this->get('/api/submission/test');
        
        $response->assertJsonFragment(['test']);
    }
}
