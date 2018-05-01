<?php

namespace Tests\Feature;

use App\Submission;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    
    
    public function testSubmissionHasUser_id(){
        $model = new Submission();
        $column = Schema::hasColumn($model->getTable(), 'user_id');
        $this->assertEquals(true, $column);
    }
    
    public function testSubmissionHasParentField(){
        $model = new Submission();
        $column = Schema::hasColumn($model->getTable(), 'parent_id');
        $this->assertEquals(true, $column);
    }
}
