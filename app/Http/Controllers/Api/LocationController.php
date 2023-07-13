<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;


class LocationController extends BaseController
{
    public function index(){
        $locations = Location::all();
        return $this->sendResponse($locations, 'Locations retrieved successfully');
    }
    public function store(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'description' => 'string',
            'thumbnail' => 'required|image'

        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }
        $path = $request->file('thumbnail')->store('public/locations');
        $input['thumbnail'] = Str::substr($path,7);
        $location = Location::create($input);
        return $this->sendResponse($location,'Locations retrieved successfully');

    }
    public function show(Location $location){
        return $this->sendResponse($location, 'Location retrieved successfully');
    }
    public function update(Request $request,Location $location){

    }
    public function destroy(Location $location){

    }
}
