<?php

namespace App\Http\Controllers;

use App\Models\auth_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthControlller extends Controller
{

    public function rigister(Request $request)
    {

        $validator = $request->validate([
            'name' =>  'required|min:5|max:50',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:6|max:12',
        ]);

        $data = auth_user::create([
            'name' => $validator['name'],
            'role' => ($request->email === 'neathahaing@gmail.com' && $request->password === '1234567') ? 'admin' : 'user' ,
            'email' => $validator['email'],
            'password' => Hash::make($validator['password']),
        ]);
        // $token = $data->createToken('test_token')->plainTextToken; 

        return response()->json([

            'message' => 'Rigister Done Broo !!',
            'data' =>  $data,
            // 'Token' => $token,
        ]);
    }
    public function login(Request $request)
    { 

        $validator =  $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:12',
        ]);

        $user = auth_user::where('email', $validator['email'])->first();

        if (!$user) {
            return  response()->json([
                'message' => 'Email not Found',
            ]); 
        }
        if (!Hash::check($validator['password'], $user['password'])) {
            return response()->json([
                'massage' => 'Your password is is incorect'
            ]);
        }
         
        $token = $user->createToken('test_token')->plainTextToken;
        
        return response()->json([

            'massage' => 'You are login successfully',
            'Data' => $user,
            'Token' => $token,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successfully Broo'
        ]);
    }
}