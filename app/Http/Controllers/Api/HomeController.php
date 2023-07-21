<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;

class HomeController extends BaseController
{
    public function getProfile(){
        $user = Auth::user();
        return $this->sendResponse(new UserResource($user), 'Profile retrieved successfully.');
    }
    public function updateProfile(Request $request){
        $input = $request->all();
        $user = Auth::user();
        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email,'.$user->id,
            'avatar' => 'string',
            'phone_number' => 'min:10',
            'gender' => 'required|numeric|min:0|max:2',
            'birthday' => 'required|date',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->phone_number = $input['phone_number'];
        $user->gender = $input['gender'];
        $user->birthday = $input['birthday'];
//        if (isset($input['avatar'])){
//            $path = $request->file('avatar')->store('public/avatars');
//            $user->avatar = Str::substr($path,7);
//        }
        $user->avatar = $input['avatar'];
        $user->save();

        return $this->sendResponse(new UserResource($user), 'Profile updated successfully.');
    }
//    public function uploadAvatar(Request $request){
//        $input = $request->all();
//        $validator = Validator::make($input, [
//            'avatar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
//        ]);
//        if($validator->fails()){
//            return $this->sendError('Validation Error.', $validator->errors());
//        }
//        $user = Auth::user();
//
////        $path = $request->file('avatar')->store('public/avatars');
//        $path = Storage::putFile('avatars', $request->file('avatar'));
//
//
//        $user->avatar = $path;
//
//        $user->save();
//
//        return $this->sendResponse($user, 'Upload image successfully.');
//    }
    public function changePassword(Request $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            'new_password' => 'required|string|min:8',
            'c_new_password' => 'required|min:8|same:new_password'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();
        if(!Hash::check($request['old_password'], $user->password )){
            return $this->sendError('alidation Error.',['old_password' => ["Old Password Doesn't match!"]], 400);
        }

        $user->password = $request['new_password'];
        $user->save();
        return $this->sendResponse([], 'Password changed successfully!');
    }
}
