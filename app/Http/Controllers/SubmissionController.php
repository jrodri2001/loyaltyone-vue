<?php

namespace App\Http\Controllers;

use App\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request){
        $this->validate($request,[
            'text' => "required",
            'user_id' => "required",
            'city' => 'required'
        ]);
        
        //lets persist this value in the database
        $submission = Submission::create([
            'text'=>$request->input('text'),
            'user_id'=> $request->input('user_id'),
            'city' => $request->input('city')
        ]);
    
        if (!$submission) {
            return $this->sendResponse("fail", 'Error creating model');
        }
        
        //return created model
        
        return $this->sendResponse('ok', 'Submission Saved', $submission);
    }
    
    
    
    public function view(){
        return Submission::with(['user','allReplies'])->where('parent_id',0)->orderby('created_at','desc')->get();
    }
    
    
    public function reply(Request $request, $id){
        $this->validate($request, [
            'text' => "required",
            'user_id' => "required",
        ]);
    
        $submission = Submission::find($id);
        
        $submission->replies()->create([
            'text'=>$request->input('text'),
            'user_id'=>$request->input('user_id'),
        ]);
    
        return $this->sendResponse('ok', 'A reply has been recorded');
    }
    
    public function latlong($city){
        /*
    Builds the URL and request to the Google Maps API
  */
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode( $city).'&key='.config( 'google_key' );
    
        /*
          Creates a Guzzle Client to make the Google Maps request.
        */
        $client = new \GuzzleHttp\Client();
    
        /*
          Send a GET request to the Google Maps API and get the body of the
          response.
        */
        $geocodeResponse = $client->get( $url )->getBody();
    
        /*
          JSON decodes the response
        */
        $geocodeData = json_decode( $geocodeResponse );
    
        /*
          Initializes the response for the GeoCode Location
        */
        $coordinates['lat'] = null;
        $coordinates['lng'] = null;
    
        /*
          If the response is not empty (something returned),
          we extract the latitude and longitude from the
          data.
        */
        if( !empty( $geocodeData )
            && $geocodeData->status != 'ZERO_RESULTS'
            && isset( $geocodeData->results )
            && isset( $geocodeData->results[0] ) ){
            $coordinates['lat'] = $geocodeData->results[0]->geometry->location->lat;
            $coordinates['lng'] = $geocodeData->results[0]->geometry->location->lng;
        }
    
        /*
          Return the found coordinates.
        */
        return $coordinates;
    }
    
    
    public function weather($city){
       
        $url = 'http://api.openweathermap.org/data/2.5/weather?q='.urlencode( $city).'&units=metric&appid='.config( 'app.weather_api' );
        
        /*
          Creates a Guzzle Client to make the Google Maps request.
        */
        $client = new \GuzzleHttp\Client();
        
        /*
          Send a GET request to the Google Maps API and get the body of the
          response.
        */
        $geocodeResponse = $client->get( $url )->getBody();
  
        return $geocodeResponse;
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
