<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['check.api', 'guest']);
    }

    //register user
    public function register(Request $request){
        $validator = Validator::make([
                            'phone' => $request->phone,
                            'password' => $request->password,
                        ],
                        [
                            'phone' => ['required', 'digits:10', 'unique:users'],
                            'password' => ['required', 'min:6', 'string'],
                        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user = User::create([
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                ]);
        
        if(!isset($user) && $user == ''){
            return response()->json(['User has not registered'], 422);
        }

        $sanctumToken = $user->createToken('mobile')->plainTextToken;
        $user->token = $sanctumToken;

        return response()->json($user, 200);
    }
}
