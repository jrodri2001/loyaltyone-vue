<?php

namespace Tests\Feature;

use App\Submission;
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
        $test = '_test_';
        
        $response = $this->post('/api/submission', [
            'text'=> $test,
            'user_id' => 1
        ]);
        
        $response->assertJsonFragment(['status'=>'ok']);
        
        //delete the currently created test
        Submission::where('text','=', $test)->delete();
        
        
    }
    
    public function testGetAllSubmissions(){
        $count = Submission::where('parent_id',0)->count();
        $response = $this->get('/api/submissions');
        $response->assertJsonCount($count);
    }
}
