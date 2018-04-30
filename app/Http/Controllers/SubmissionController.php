<?php

namespace App\Http\Controllers;

use App\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request){
        $this->validate($request,[
            'text'=>"required"
        ]);
        
        //lets persist this value in the database
        $submission = Submission::create([
            'text'=>$request->input('text')
        ]);
    
        if (!$submission) {
            return $this->sendResponse("fail", 'Error creating model');
        }
        
        //return created model
        
        return $this->sendResponse('ok', 'Submission Saved', $submission);
    }
    
    
    private function sendResponse($status, $message = null, $data = null)
    {
        $response = [
            "status" => $status
        ];
        
        if ($message) {
            $response['message'] = $message;
        }
        
        if ($data){
            $response['data'] = $data;
        }
        
        return json_encode($response);
    }
}
