<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// class AuthController extends Controller
// {

//     public function __construct()
//     {
//         $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh', 'logout']]);
//     }

//     public function register(Request $request)
//     {
//         $request->validate([
//             'login' => 'required',
//             'senha' => 'required',
//         ]);

//         $user = Usuario::create([
//             'login' => $request->login,
//             'senha' => Hash::make($request->senha),
//         ]);

//         $token = Auth::guard('api')->login($user);
//         return response()->json([
//             'status' => 'success',
//             'message' => 'User created successfully',
//             'user' => $user,
//             'authorisation' => [
//                 'token' => $token,
//                 'type' => 'bearer',
//             ]
//         ]);
//     }

//     public function login(Request $request)
//     {
//         $request->validate([
//             'login' => 'required',
//             'senha' => 'required',
//         ]);
//         $credentials = $request->only('login', 'senha');

//         $token = Auth::guard('api')->attempt($credentials);
//         if (!$token) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => 'Unauthorized',
//             ], 401);
//         }

//         $user = Auth::guard('api')->user();
//         return response()->json([
//             'status' => 'success',
//             'user' => $user,
//             'authorisation' => [
//                 'token' => $token,
//                 'type' => 'bearer',
//             ]
//         ]);
//     }

//     public function logout()
//     {
//         Auth::guard('api')->logout();
//         return response()->json([
//             'status' => 'success',
//             'message' => 'Successfully logged out',
//         ]);
//     }


//     public function refresh()
//     {
//         return response()->json([
//             'status' => 'success',
//             'user' => Auth::guard('api')->user(),
//             'authorisation' => [
//                 'token' => Auth::guard('api')->refresh(),
//                 'type' => 'bearer',
//             ]
//         ]);
//     }
// }
