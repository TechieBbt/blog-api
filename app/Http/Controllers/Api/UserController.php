<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index (){
        return "Welcome to User API!";
    }
    public function createUser (Request $request){

        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|Max:50',
            'email'=> 'required|string|Max:100|unique:users',
            'password'=> 'required|string|Max:8',

        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()
            ], 422);
        } 
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());
        $token = $user->createToken('token-name')->plainTextToken;
        $userToken = ['token' => $token];
        return response()->json([
            'status' => 201,
            'message' => 'User created successfully', 
            'userToken' => $userToken,
        ]);
    }

    public function login (Request $request){

        $validator = Validator::make($request->all(), [
            'email'=> 'required|string|Max:100',
            'password'=> 'required|string|Max:8',

        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()
            ], 422);
        } 
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)){
                $token = $user->createToken('Laravel Password Grant Client')-> accessToken;
                $response = ['token' => $token];
                return response()->json([
                    'status' => 200,
                    'message' => 'Login successful'
                ]);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }

}