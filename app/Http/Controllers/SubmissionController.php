<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request, $text){
        return json_encode($text);
    }
}
