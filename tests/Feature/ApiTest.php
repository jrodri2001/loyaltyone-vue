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
        $response = $this->post('/api/submission', ['text'=>'test']);
        
        $response->assertJsonFragment(['data'=>'test']);
    }
}
