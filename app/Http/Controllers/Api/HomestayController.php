<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Homestay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomestayController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $homestays = Homestay::query();
        if ($request->has('user_id') && isset($request->user_id)){
            $homestays->where('user_id', $request->user_id);
        }
        return $this->sendResponse($homestays->paginate(), 'Homestays achieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'location_id' => 'required|numeric',
            'address' => 'required|string',
            'avatar' => 'required|image',
            'images' => 'required|string',
            'desc' => 'required|string',
            'restaurant' => 'required|boolean',
            'free_wifi' => 'required|boolean',
            'pool' => 'required|boolean',
            'spa' => 'required|boolean',
            'bar' => 'required|boolean',
            'breakfast' => 'required|boolean',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $input['user_id'] = $user->id;
        $path = $request->file('avatar')->store('public/homestay/avatars');
        $input['avatar'] = Str::substr($path,7);
        $input['restaurant'] = filter_var($input['restaurant'], FILTER_VALIDATE_BOOLEAN);
        $input['free_wifi'] = filter_var($input['free_wifi'], FILTER_VALIDATE_BOOLEAN);
        $input['pool'] = filter_var($input['pool'], FILTER_VALIDATE_BOOLEAN);
        $input['spa'] = filter_var($input['spa'], FILTER_VALIDATE_BOOLEAN);
        $input['bar'] = filter_var($input['bar'], FILTER_VALIDATE_BOOLEAN);
        $input['breakfast'] = filter_var($input['breakfast'], FILTER_VALIDATE_BOOLEAN);
        $homestay = Homestay::create($input);
        return $this->sendResponse($homestay,'Homestay created successfully.', 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Homestay $homestay)
    {
        return $this->sendResponse($homestay, 'Homestay achieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Homestay $homestay)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'location_id' => 'required|numeric',
            'address' => 'required|string',
            'avatar' => 'image',
            'images' => 'required|string',
            'desc' => 'required|string',
            'restaurant' => 'required|boolean',
            'free_wifi' => 'required|boolean',
            'pool' => 'required|boolean',
            'spa' => 'required|boolean',
            'bar' => 'required|boolean',
            'breakfast' => 'required|boolean',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $homestay->name = $input['name'];
        $homestay->location_id = $input['location_id'];
        $homestay->address = $input['address'];
        $homestay->images = $input['images'];
        $homestay->desc = $input['desc'];
        $homestay->restaurant = $input['restaurant'];
        $homestay->free_wifi = $input['free_wifi'];
        $homestay->pool = $input['pool'];
        $homestay->spa = $input['spa'];
        $homestay->bar = $input['bar'];
        $homestay->breakfast = $input['breakfast'];

        if (isset($input['avatar'])){
            $path = $request->file('avatar')->store('public/homestay/avatars');
            $homestay->avatar = Str::substr($path,7);
        }
        $homestay->save();
        return $this->sendResponse($homestay,'Homestay updated successfully.' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Homestay $homestay)
    {
        $homestay->delete();
        return $this->sendResponse([], 'Homestay deleted successfully.');
    }

}
