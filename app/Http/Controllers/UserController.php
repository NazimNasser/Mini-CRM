<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAll()
    {
        $user  = User::all();
        // $user= User::orderBy('name')->get();
        $respond = [
            'status' => 201,
            'message' => "All User",
            'data' => $user,
        ];

        return $respond;
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'string|between:2,100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User have been logged out']);
    }

    public function delete($id){

        $user = User::find($id);

        if(isset($user)){
            $user->delete();
            $all_users = User::all();

            $respond = [
                'status'=> 201,
                'message' =>  "Successfully Deleted",
                'data' => $all_users,
            ];
            return $respond;
        }

            $respond = [
                'status'=> 404,
                'message' =>  "User with id=$id doesn't exist",
                'data' => null,
            ];

        return $respond;
    }
}
