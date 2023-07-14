<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\LocationResource;
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
            'description' => 'required|string',
            'thumbnail' => 'required|image'

        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }
        $path = $request->file('thumbnail')->store('public/locations');
        $input['thumbnail'] = Str::substr($path,7);
        $location = Location::create($input);
        return $this->sendResponse(new LocationResource($location),'Location created successfully.', 201);

    }
    public function show(Location $location){
        return $this->sendResponse($location, 'Location retrieved successfully');
    }
    public function update(Request $request,Location $location){
        $input = $request->all();
//        dd($input);
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'description' => 'required|string',
            'thumbnail' => 'image'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $location->name = $input['name'];
        $location->description = $input['description'];
        if (isset($input['thumbnail'])){
            $path = $request->file('thumbnail')->store('public/locations');
            $location->thumbnail = Str::substr($path,7);
        }
        $location->save();
        return $this->sendResponse($location, 'Location updated successfully.');

    }
    public function destroy(Location $location){
        $location->delete();
        return $this->sendResponse([], 'Location deleted successfully.');

    }
}
