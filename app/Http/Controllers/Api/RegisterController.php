<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\API\BaseController ;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Http\JsonResponse;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
//        dd($request->all());
//        return $this->sendResponse($request->all(), 'User register successfully.');
//        $messages = [
//            'phone_number.min' => 'Invalid phone_number'
//        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email',
//            'avatar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'phone_number' => 'nullable|string|min:10',
            'gender' => 'required|numeric|min:0|max:2',
            'birthday' => 'required|date',
            'role' => 'required|numeric|min:0|max:2',
            'password' => 'required|string|min:8',
            'c_password' => 'required|min:8|same:password',
        ],
//            $messages

        );

        if($validator->fails()){
//            dd($validator->errors());
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $input = $request->all();
//        dd(isset($input['avatar']));
//        if (isset($input['avatar'])){
//            $path = $request->file('avatar')->store('public/avatars');
//            $input['avatar'] = Str::substr($path,7);
//        }
//        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['id'] =  $user->id;
        $success['name'] =  $user->name;
        $success['role'] = $user->role;
        $success['avatar'] = null;


        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['role'] = $user->role;
            $success['avatar'] = $user->avatar;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 401);
        }
    }
}
