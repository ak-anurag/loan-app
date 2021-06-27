<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['check.api', 'guest']);
    }

    //login user
    public function login(Request $request){
        $validator = Validator::make([
                            'phone' => $request->phone,
                            'password' => $request->password,
                        ],
                        [
                            'phone' => ['required', 'digits:10'],
                            'password' => ['required', 'min:6', 'string'],
                        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user = User::where('phone', $request->phone)->first();

        if(!isset($user) || !Hash::check($request->password, $user->password)){
            return response()->json(['Invalid phone or password'], 401);
        }

        $sanctumToken = $user->createToken('mobile')->plainTextToken;
        $user->token = $sanctumToken;

        return response()->json($user, 200);
    }
}
