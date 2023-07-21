<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Homestay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;

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
        $homestays = $homestays->join('locations', 'homestays.location_id', '=', 'locations.id')
                    ->select('homestays.*','locations.name as location_name')
                    ->get();
        return $this->sendResponse($homestays, 'Homestays achieved successfully');
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
            'avatar' => 'required|string',
            'desc' => 'required|string',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }
        $input['user_id'] = $user->id;
        $input['images'] =json_encode($input['images']);
        $input['utilities'] =json_encode($input['utilities']);
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
            'avatar' => 'required|string',
            'desc' => 'required|string',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $homestay->name = $input['name'];
        $homestay->location_id = $input['location_id'];
        $homestay->address = $input['address'];
        $homestay->images = json_encode($input['images']);
        $homestay->desc = $input['desc'];
        $homestay->utilities = json_encode($input['utilities']);
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
    public function top(){
        $homestays = DB::select ('SELECT t.id, t.name, l.name AS location_name, Round(AVG(b.point), 1) AS pointz, COUNT(b.point) AS countz, t.min_price FROM bookings b
RIGHT JOIN
(SELECT h.id, h.name, h.location_id, h.avatar, MIN(r.price) AS min_price FROM homestays h INNER JOIN rooms r ON h.id = r.homestay_id GROUP BY h.id) t ON  b.homestay_id = t.id
INNER JOIN locations l ON l.id = t.location_id
GROUP BY t.id
ORDER BY AVG(b.point) DESC, countz DESC
LIMIT 8 ');




        return $this->sendResponse($homestays, 'Top homestays retrieved successfully');
    }

}
