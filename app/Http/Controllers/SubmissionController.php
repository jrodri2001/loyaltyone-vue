<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request){
        $this->validate($request,[
            'text'=>"required"
        ]);
        
        return ['status'=>'ok', 'data'=>$request->input('text')];
    }
}
