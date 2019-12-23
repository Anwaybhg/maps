<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SKAgarwal\GoogleApi\PlacesApi;
use App\PlacesResult;
class HomeController extends Controller
{
    //
    public function __construct(PlacesResult $result){
        $this->result = $result;
    }

    public function findPlaces(Request $request){
        $response = ['success'=>0,'data'=>[]];
        $request = $request->all();
        $lat = @$request['latitude'];
        $lng = @$request['longitude'];

        if(empty($lat) || empty($lng)){
            $response['data'] = 'Invalid Location Provided';
            return response()->json($response);
        }
        $latPattern = $lngPattern = '';

        if(substr($lat,0,1) == '-'){
            $latPattern = substr($lat,0,5);
        }else{
            $latPattern = substr($lat,0,4);
        }

        if(substr($lng,0,1) == '-'){
            $lngPattern = substr($lng,0,5);
        }else{
            $lngPattern = substr($lng,0,4);
        }
        $storedRecs = $this->result->where('latitude','like%',$latPattern)->where('longitude','like%',$lngPattern)->first();
        if($storedRecs){
            $response['data'] = $storedRecs['result'];
            $response['success'] = 1;
            return response()->json($response);
        }
        try{
        $googlePlaces = new PlacesApi(env('MAPS_API_KEY'));
        $location = [floatval($lat),floatval($lng)];
        $radius = 5000;
        $apiResponse = $googlePlaces->nearbySearch($location,$radius,['type'=>'restaurant']);
        }catch(\Exception $e){
            $response['data'] = 'API Error';
            return response()->json($response);
        }
        if(!empty($apiReponse['results'])){
            $this->result->create(['latitude'=>$lat,'longitude'=>$lng,'radius'=>$radius,'result'=>$apiResponse['results']]);
            $response['data'] = $apiResponse['results'];
            $response['success'] = 1;
            return response()->json($response);

        }
        
    }




}
