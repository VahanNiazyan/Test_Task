<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{


    public function region(Request $request){
        $region = Region::create([
            'name' => $request['name'],
            'time' => $request['time'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
            'temp' => $request['temp'],
            'pressure' => $request['pressure'],
            'humidity' => $request['humidity'],
            'temp_min' => $request['temp_min'],
            'temp_max' => $request['temp_max']
        ]);

        return response()->json(Region::orderBy('id', 'desc')->first());
    }
}
