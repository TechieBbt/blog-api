<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index (){
        return "Welcome to User API!";
    }
    public function createUser (Request $request){

        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|Max:50',
            'email'=> 'required|string|Max:100',
            'password'=> 'required|string|Max:8',

        ]);

        if ($validator->fails())
        {
            return response() ->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
            ]);
        
            if ($user) {
                return response()->json([
                    'status' => 201,
                    'message' => 'User created successfully'
                ], 201);
            }else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong'
                ], 500);
            }
              
        }
    }
}
