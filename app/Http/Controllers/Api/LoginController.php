<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        if($request->email){
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user= User::where('email', $request->email)->first();

                if (!$user || !Hash::check($request->password, $user->password)) {
                    return response([
                        'success'   => false,
                        'message' => ['These credentials do not match our records.']
                    ], 404);
                }

                //delete token store
                if($user->tokens()->where('tokenable_id', $user->id)->exists()){
                    $user->tokens()->delete();
                }

                $token = $user->createToken('MyApp')->plainTextToken;


            return response()->json([
                'success' => true,
                'user'    => $user,
                'tokenn'  => $token
            ], 201);
        }else{
            return response()->json([
                'success'   => false,
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'success'    => true
        ], 200);
    }

}
