<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate();
        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $authUser = Auth::user();
        if ($authUser->role != 0){
            return $this->sendError('Unauthorized.', [], 401);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email',
            'phone_number' => 'min:10',
            'gender' => 'required|numeric|min:0|max:2',
            'birthday' => 'date',
            'role' => 'required|numeric|min:1|max:2',
            'password' => 'required|string|min:8',
            'c_password' => 'required|min:8|same:password',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::create($input);
        return $this->sendResponse(new UserResource($user), 'User created successfully.',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        //        if (is_null($product)) {
//            return $this->sendError('Product not found.');
//        }
        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email',
            'phone_number' => 'min:10',
            'gender' => 'required|numeric|min:0|max:2',
            'birthday' => 'date',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->phone_number = $input['phone_number'];
        $user->gender = $input['gender'];
        $user->birthday = $input['birthday'];
        $user->save();
        return $this->sendResponse(new ProductResource($user), 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $authUser = auth()->user();
        if ($authUser->role != 0){
            return $this->sendError('Unauthorized.', [], 401);
        }
        $user->delete();
        return $this->sendResponse([], 'User deleted successfully.');
    }

    public function uploadAvatar(Request $request, User $user){
        $input = $request->all();
        $validator = Validator::make($input, [
            'avatar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $path = $request->file('avatar')->store('avatars');
        $user->avatar = $path;
        $user->save();
        return $this->sendResponse($user, 'Upload image successfully.');
    }
    public function changePassword(Request $request, User $user){
        $input = $request->all();

        $validator = Validator::make($input, [
            'new_password' => 'required|string|min:8',
            'c_new_password' => 'required|min:8|same:new_password'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user->password = $request['new_password'];
        $user->save();
        return $this->sendResponse([], 'Password changed successfully!');
    }
}
