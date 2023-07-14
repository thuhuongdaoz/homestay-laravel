<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomestayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'location_id' => 'required|numeric',
            'address' => 'required|string',
            'preview_image' => 'required|image',
            'desc' => 'string',
            'restaurant' => 'required|boolean',
            'free-wifi' => 'required|boolean',
            'pool' => 'required|boolean',
            'spa' => 'required|boolean',
            'bar' => 'required|boolean',
            'breakfast' => 'required|boolean',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }
        $path = $request->file('thumbnail')->store('public/locations');
        $input['thumbnail'] = Str::substr($path,7);
        $location = Location::create($input);
        return $this->sendResponse(new LocationResource($location),'Location created successfully.', 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
