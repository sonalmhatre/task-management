<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    //POST [name,emai,password]
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed'
        ]);
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'User registered successfully',
            'data'=>[]
        ]);
    }
    //POST [email,password]
    public function login(Request $request){
        $request->validate([
           'email'=>'required|email',
            'password'=>'required'
        ]);
        $user = User::where('email',$request->email)->first();
        if(!empty($user)){
            if(Hash::check($request->password,$user->password)){
                $token = $user->createToken('myToken')->accessToken;
                return response()->json([
                    'status'=>true,
                    'message'=>'Login successful',
                    'data'=>[],
                    'token'=>$token
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Password didnt matched',
                    'data'=>[]
                ]);
            }
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Invalid email value',
                'data'=>[]
            ]);
        }

    }
    //GET [token]
    public function profile(){
        $user = auth()->user();
        return response()->json([
            'status'=>true,
            'message'=>'User Information',
            'data'=>$user
        ]);
    }
    //GET [token]
    public function logout(){
        $token = auth()->user()->token();
        $token->revoke();
        return response()->json([
            'status'=>true,
            'message'=>'User logout successfully'
        ]);
    }
}
