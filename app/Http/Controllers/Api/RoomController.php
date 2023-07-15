<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return $this->sendResponse($rooms,'Rooms retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'homestay_id' => 'required|numeric',
            'name' => 'required|string',
            'adults' => 'required|numeric',
            'child' => 'required|numeric',
            'price' => 'required|numeric',
            'count' => 'required|numeric',
        ]);

        if ($validator->fails()){
            $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $room = Room::create($input);
        return $this->sendResponse($room, 'Room created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return $this->sendResponse($room, 'Room achieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'homestay_id' => 'required|numeric',
            'name' => 'required|string',
            'adults' => 'required|numeric',
            'child' => 'required|numeric',
            'price' => 'required|numeric',
            'count' => 'required|numeric',
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation Error.',$validator->errors(), 400);
        }

        $room->homestay_id = $input['homestay_id'];
        $room->name = $input['name'];
        $room->adults = $input['adults'];
        $room->child = $input['child'];
        $room->price = $input['price'];
        $room->count = $input['count'];

        $room->save();

        return $this->sendResponse($room, 'Room updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return $this->sendResponse([], 'Room deleted successfully');
    }
}
