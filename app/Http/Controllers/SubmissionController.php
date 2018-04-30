<?php

namespace App\Http\Controllers;

use App\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request){
        $this->validate($request,[
            'text'=>"required",
            'user_id'=>"required"
        ]);
        
        //lets persist this value in the database
        $submission = Submission::create([
            'text'=>$request->input('text'),
            'user_id'=> $request->input('user_id')
        ]);
    
        if (!$submission) {
            return $this->sendResponse("fail", 'Error creating model');
        }
        
        //return created model
        
        return $this->sendResponse('ok', 'Submission Saved', $submission);
    }
    
    
    
    public function view(){
        return Submission::with('user')->orderby('created_at','desc')->get();
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
